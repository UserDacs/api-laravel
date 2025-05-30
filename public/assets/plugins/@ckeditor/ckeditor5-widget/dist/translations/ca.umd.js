/**
 * @license Copyright (c) 2003-2024, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

( e => {
const { [ 'ca' ]: { dictionary, getPluralForm } } = {"ca":{"dictionary":{"Widget toolbar":"Barra d'eines de ginys","Insert paragraph before block":"Inserir un paràgraf abans del bloc","Insert paragraph after block":"Inserir un paràgraf després del bloc","Press Enter to type after or press Shift + Enter to type before the widget":"Premeu Retorn per escriure després o premeu Maj + Retorn per escriure abans del giny","Keystrokes that can be used when a widget is selected (for example: image, table, etc.)":"Tecles que es poden emprar en seleccionar un giny (com ara: imatge, taula, etc.)","Insert a new paragraph directly after a widget":"Insereix un paràgraf nou immediatament després d'un giny","Insert a new paragraph directly before a widget":"Insereix un paràgraf nou immediatament abans d'un giny","Move the caret to allow typing directly before a widget":"Mou el punt d'inserció per a permetre l'escriptura immediatament abans d'un giny","Move the caret to allow typing directly after a widget":"Mou el punt d'inserció per a permetre l'escriptura immediatament després d'un giny","Move focus from an editable area back to the parent widget":"Torna a moure el focus des d'una àrea editable al giny principal"},getPluralForm(n){return (n != 1);}}};
e[ 'ca' ] ||= { dictionary: {}, getPluralForm: null };
e[ 'ca' ].dictionary = Object.assign( e[ 'ca' ].dictionary, dictionary );
e[ 'ca' ].getPluralForm = getPluralForm;
} )( window.CKEDITOR_TRANSLATIONS ||= {} );
