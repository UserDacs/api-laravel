/**
 * @license Copyright (c) 2003-2024, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */
/**
 * @module list/listproperties/listpropertiesediting
 */
import { Plugin } from 'ckeditor5/src/core.js';
import ListEditing from '../list/listediting.js';
import ListStartCommand from './liststartcommand.js';
import ListStyleCommand from './liststylecommand.js';
import ListReversedCommand from './listreversedcommand.js';
import { listPropertiesUpcastConverter } from './converters.js';
import { getAllSupportedStyleTypes, getListTypeFromListStyleType, getListStyleTypeFromTypeAttribute, getTypeAttributeFromListStyleType } from './utils/style.js';
import ListPropertiesUtils from './listpropertiesutils.js';
import { isNumberedListType } from '../list/utils/model.js';
const DEFAULT_LIST_TYPE = 'default';
/**
 * The document list properties engine feature.
 *
 * It registers the `'listStyle'`, `'listReversed'` and `'listStart'` commands if they are enabled in the configuration.
 * Read more in {@link module:list/listconfig~ListPropertiesConfig}.
 */
export default class ListPropertiesEditing extends Plugin {
    /**
     * @inheritDoc
     */
    static get requires() {
        return [ListEditing, ListPropertiesUtils];
    }
    /**
     * @inheritDoc
     */
    static get pluginName() {
        return 'ListPropertiesEditing';
    }
    /**
     * @inheritDoc
     */
    constructor(editor) {
        super(editor);
        editor.config.define('list.properties', {
            styles: true,
            startIndex: false,
            reversed: false
        });
    }
    /**
     * @inheritDoc
     */
    init() {
        const editor = this.editor;
        const model = editor.model;
        const listEditing = editor.plugins.get(ListEditing);
        const enabledProperties = editor.config.get('list.properties');
        const strategies = createAttributeStrategies(enabledProperties);
        for (const strategy of strategies) {
            strategy.addCommand(editor);
            model.schema.extend('$listItem', { allowAttributes: strategy.attributeName });
            // Register downcast strategy.
            listEditing.registerDowncastStrategy({
                scope: 'list',
                attributeName: strategy.attributeName,
                setAttributeOnDowncast(writer, attributeValue, viewElement) {
                    strategy.setAttributeOnDowncast(writer, attributeValue, viewElement);
                }
            });
        }
        // Set up conversion.
        editor.conversion.for('upcast').add(dispatcher => {
            for (const strategy of strategies) {
                dispatcher.on('element:ol', listPropertiesUpcastConverter(strategy));
                dispatcher.on('element:ul', listPropertiesUpcastConverter(strategy));
            }
        });
        // Verify if the list view element (ul or ol) requires refreshing.
        listEditing.on('checkAttributes:list', (evt, { viewElement, modelAttributes }) => {
            for (const strategy of strategies) {
                if (strategy.getAttributeOnUpcast(viewElement) != modelAttributes[strategy.attributeName]) {
                    evt.return = true;
                    evt.stop();
                }
            }
        });
        // Reset list properties after indenting list items.
        this.listenTo(editor.commands.get('indentList'), 'afterExecute', (evt, changedBlocks) => {
            model.change(writer => {
                for (const node of changedBlocks) {
                    for (const strategy of strategies) {
                        if (strategy.appliesToListItem(node)) {
                            // Just reset the attribute.
                            // If there is a previous indented list that this node should be merged into,
                            // the postfixer will unify all the attributes of both sub-lists.
                            writer.setAttribute(strategy.attributeName, strategy.defaultValue, node);
                        }
                    }
                }
            });
        });
        // Add or remove list properties attributes depending on the list type.
        listEditing.on('postFixer', (evt, { listNodes, writer }) => {
            for (const { node } of listNodes) {
                for (const strategy of strategies) {
                    // Check if attribute is valid.
                    if (strategy.hasValidAttribute(node)) {
                        continue;
                    }
                    // Add missing default property attributes...
                    if (strategy.appliesToListItem(node)) {
                        writer.setAttribute(strategy.attributeName, strategy.defaultValue, node);
                    }
                    // ...or remove invalid property attributes.
                    else {
                        writer.removeAttribute(strategy.attributeName, node);
                    }
                    evt.return = true;
                }
            }
        });
        // Make sure that all items in a single list (items at the same level & listType) have the same properties.
        listEditing.on('postFixer', (evt, { listNodes, writer }) => {
            for (const { node, previousNodeInList } of listNodes) {
                // This is a first item of a nested list.
                if (!previousNodeInList) {
                    continue;
                }
                // This is a first block of a list of a different type.
                if (previousNodeInList.getAttribute('listType') != node.getAttribute('listType')) {
                    continue;
                }
                // Copy properties from the previous one.
                for (const strategy of strategies) {
                    const { attributeName } = strategy;
                    if (!strategy.appliesToListItem(node)) {
                        continue;
                    }
                    const value = previousNodeInList.getAttribute(attributeName);
                    if (node.getAttribute(attributeName) != value) {
                        writer.setAttribute(attributeName, value, node);
                        evt.return = true;
                    }
                }
            }
        });
    }
}
/**
 * Creates an array of strategies for dealing with enabled listItem attributes.
 */
function createAttributeStrategies(enabledProperties) {
    const strategies = [];
    if (enabledProperties.styles) {
        const useAttribute = typeof enabledProperties.styles == 'object' && enabledProperties.styles.useAttribute;
        strategies.push({
            attributeName: 'listStyle',
            defaultValue: DEFAULT_LIST_TYPE,
            viewConsumables: { styles: 'list-style-type' },
            addCommand(editor) {
                let supportedTypes = getAllSupportedStyleTypes();
                if (useAttribute) {
                    supportedTypes = supportedTypes.filter(styleType => !!getTypeAttributeFromListStyleType(styleType));
                }
                editor.commands.add('listStyle', new ListStyleCommand(editor, DEFAULT_LIST_TYPE, supportedTypes));
            },
            appliesToListItem(item) {
                return item.getAttribute('listType') == 'numbered' || item.getAttribute('listType') == 'bulleted';
            },
            hasValidAttribute(item) {
                if (!this.appliesToListItem(item)) {
                    return !item.hasAttribute('listStyle');
                }
                if (!item.hasAttribute('listStyle')) {
                    return false;
                }
                const value = item.getAttribute('listStyle');
                if (value == DEFAULT_LIST_TYPE) {
                    return true;
                }
                return getListTypeFromListStyleType(value) == item.getAttribute('listType');
            },
            setAttributeOnDowncast(writer, listStyle, element) {
                if (listStyle && listStyle !== DEFAULT_LIST_TYPE) {
                    if (useAttribute) {
                        const value = getTypeAttributeFromListStyleType(listStyle);
                        if (value) {
                            writer.setAttribute('type', value, element);
                            return;
                        }
                    }
                    else {
                        writer.setStyle('list-style-type', listStyle, element);
                        return;
                    }
                }
                writer.removeStyle('list-style-type', element);
                writer.removeAttribute('type', element);
            },
            getAttributeOnUpcast(listParent) {
                const style = listParent.getStyle('list-style-type');
                if (style) {
                    return style;
                }
                const attribute = listParent.getAttribute('type');
                if (attribute) {
                    return getListStyleTypeFromTypeAttribute(attribute);
                }
                return DEFAULT_LIST_TYPE;
            }
        });
    }
    if (enabledProperties.reversed) {
        strategies.push({
            attributeName: 'listReversed',
            defaultValue: false,
            viewConsumables: { attributes: 'reversed' },
            addCommand(editor) {
                editor.commands.add('listReversed', new ListReversedCommand(editor));
            },
            appliesToListItem(item) {
                return item.getAttribute('listType') == 'numbered';
            },
            hasValidAttribute(item) {
                return this.appliesToListItem(item) == item.hasAttribute('listReversed');
            },
            setAttributeOnDowncast(writer, listReversed, element) {
                if (listReversed) {
                    writer.setAttribute('reversed', 'reversed', element);
                }
                else {
                    writer.removeAttribute('reversed', element);
                }
            },
            getAttributeOnUpcast(listParent) {
                return listParent.hasAttribute('reversed');
            }
        });
    }
    if (enabledProperties.startIndex) {
        strategies.push({
            attributeName: 'listStart',
            defaultValue: 1,
            viewConsumables: { attributes: 'start' },
            addCommand(editor) {
                editor.commands.add('listStart', new ListStartCommand(editor));
            },
            appliesToListItem(item) {
                return isNumberedListType(item.getAttribute('listType'));
            },
            hasValidAttribute(item) {
                return this.appliesToListItem(item) == item.hasAttribute('listStart');
            },
            setAttributeOnDowncast(writer, listStart, element) {
                if (listStart == 0 || listStart > 1) {
                    writer.setAttribute('start', listStart, element);
                }
                else {
                    writer.removeAttribute('start', element);
                }
            },
            getAttributeOnUpcast(listParent) {
                const startAttributeValue = listParent.getAttribute('start');
                return startAttributeValue >= 0 ? startAttributeValue : 1;
            }
        });
    }
    return strategies;
}
