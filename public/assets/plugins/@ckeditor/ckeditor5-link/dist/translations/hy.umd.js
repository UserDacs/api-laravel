/**
 * @license Copyright (c) 2003-2024, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

( e => {
const { [ 'hy' ]: { dictionary, getPluralForm } } = {"hy":{"dictionary":{"Unlink":"","Link":"Հղում","Link URL":"","Link URL must not be empty.":"","Link image":"","Edit link":"Խմբագրել հղումը","Open link in new tab":"","This link has no URL":"","Open in a new tab":"","Downloadable":"","Create link":"","Move out of a link":""},getPluralForm(n){return (n != 1);}}};
e[ 'hy' ] ||= { dictionary: {}, getPluralForm: null };
e[ 'hy' ].dictionary = Object.assign( e[ 'hy' ].dictionary, dictionary );
e[ 'hy' ].getPluralForm = getPluralForm;
} )( window.CKEDITOR_TRANSLATIONS ||= {} );
