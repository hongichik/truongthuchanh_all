/**
 * This configuration was generated using the CKEditor 5 Builder. You can modify it anytime using this link:
 * https://ckeditor.com/ckeditor-5/builder/#installation/NoDgNARAzAdADDATBSjFTlAjAFhDnAdkRwE4A2UwkROHAVhMXtKhHIcS2/qyhyzUcKCAFMAdiihhgWMHHmKFcALqQQ+UqIDG2iCqA===
 */

import {
	DecoupledEditor,
	Autosave,
	Essentials,
	Paragraph,
	ImageUtils,
	ImageEditing,
	Table,
	TableToolbar,
	TableProperties,
	TableCellProperties,
	TableColumnResize,
	TableCaption,
	Heading,
	Link,
	AutoLink,
	Bookmark,
	BlockQuote,
	HorizontalLine,
	CodeBlock,
	Indent,
	IndentBlock,
	Alignment,
	ImageInline,
	ImageToolbar,
	ImageBlock,
	ImageResize,
	ImageUpload,
	ImageInsertViaUrl,
	AutoImage,
	ImageStyle,
	LinkImage,
	ImageCaption,
	ImageTextAlternative,
	ShowBlocks,
	GeneralHtmlSupport,
	HtmlEmbed,
	HtmlComment,
	FullPage
} from 'ckeditor5';

// URL tuyệt đối đến node server xử lý upload
const UPLOAD_URL = '/admin/uploads/image'; // Updated for Laravel

// Upload adapter: gửi file lên server, nhận về URL và hiển thị link ảnh
function LocalImageUploadAdapter( editor ) {
	editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
		let controller = new AbortController();
		return {
			upload() {
				return loader.file.then( file => {
					const data = new FormData();
					data.append( 'upload', file );
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (csrfToken) { data.append('_token', csrfToken.getAttribute('content')); }
					return fetch( UPLOAD_URL, {
						method: 'POST',
						body: data,
						signal: controller.signal,
                        headers: {
                            'Accept': 'application/json'
                        }
					} )
					.then( response => {
						if ( !response.ok ) throw new Error( 'Upload thất bại: ' + response.statusText );
						return response.json();
					} )
					.then( result => {
						// Server phải trả về JSON dạng: { "url": "https://..." }
						if ( !result.url ) throw new Error( 'Server không trả về url ảnh' );
						return { default: result.url };
					} );
				} );
			},
			abort() {
				controller.abort();
			}
		};
	};
}


const editorConfig = {
	root: {
		placeholder: 'Type or paste your content here!',
		element: document.querySelector('#content-editor'),
	},
	toolbar: {
		items: [
			'undo',
			'redo',
			'|',

			'showBlocks',
			'|',
			'heading',
			'|',
			'horizontalLine',
			'link',
			'bookmark',
			'insertTable',
			'blockQuote',
			'codeBlock',
			'htmlEmbed',
			'|',
			'alignment',
			'lineHeight',
			'|',
			'outdent',
			'indent'
		],
		shouldNotGroupWhenFull: true
	},
	plugins: [
		Alignment,
		AutoImage,
		AutoLink,
		Autosave,
		BlockQuote,
		Bookmark,
		CodeBlock,
		Essentials,
		FullPage,
		GeneralHtmlSupport,
		Heading,
		HorizontalLine,
		HtmlComment,
		HtmlEmbed,
		ImageBlock,
		ImageCaption,
		ImageEditing,
		ImageInline,
		ImageInsertViaUrl,
		ImageResize,
		ImageStyle,
		ImageTextAlternative,
		ImageToolbar,
		ImageUpload,
		ImageUtils,
		LocalImageUploadAdapter,
		Indent,
		IndentBlock,
		Link,
		LinkImage,
		Paragraph,
		ShowBlocks,
		Table,
		TableCaption,
		TableCellProperties,
		TableColumnResize,
		TableProperties,
		TableToolbar
	],
	licenseKey: 'GPL',
	heading: {
		options: [
			{
				model: 'paragraph',
				title: 'Paragraph',
				class: 'ck-heading_paragraph'
			},
			{
				model: 'heading1',
				view: 'h1',
				title: 'Heading 1',
				class: 'ck-heading_heading1'
			},
			{
				model: 'heading2',
				view: 'h2',
				title: 'Heading 2',
				class: 'ck-heading_heading2'
			},
			{
				model: 'heading3',
				view: 'h3',
				title: 'Heading 3',
				class: 'ck-heading_heading3'
			},
			{
				model: 'heading4',
				view: 'h4',
				title: 'Heading 4',
				class: 'ck-heading_heading4'
			},
			{
				model: 'heading5',
				view: 'h5',
				title: 'Heading 5',
				class: 'ck-heading_heading5'
			},
			{
				model: 'heading6',
				view: 'h6',
				title: 'Heading 6',
				class: 'ck-heading_heading6'
			}
		]
	},
	htmlSupport: {
		allow: [
			{
				name: /^.*$/,
				styles: true,
				attributes: true,
				classes: true
			}
		]
	},
	image: {
		toolbar: [
			'toggleImageCaption',
			'imageTextAlternative',
			'|',
			'imageStyle:inline',
			'imageStyle:wrapText',
			'imageStyle:breakText',
			'|',
			'resizeImage'
		]
	},
	link: {
		addTargetToExternalLinks: true,
		defaultProtocol: 'https://',
		decorators: {
			toggleDownloadable: {
				mode: 'manual',
				label: 'Downloadable',
				attributes: {
					download: 'file'
				}
			}
		}
	},
	table: {
		contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
	}
};

DecoupledEditor.create(editorConfig).then(editor => {
    const toolbarContainer = document.querySelector('#content-editor').parentNode;
	toolbarContainer.insertBefore(editor.ui.view.toolbar.element, document.querySelector('#content-editor'));

	// Save data to textarea on submit
	const form = document.querySelector('#content-editor').closest('form');
	if (form) {
		form.addEventListener('submit', () => {
			document.querySelector('#content').value = editor.getData();
		});
	}

// Phím Tab: chèn 4 khoảng trắng (mô phỏng phím tab)
	editor.editing.view.document.on('keydown', (evt, data) => {
		if (data.keyCode !== 9) return; // 9 = Tab
		data.preventDefault();
		evt.stop();
		editor.model.change(writer => {
			writer.insertText('\u00a0\u00a0\u00a0\u00a0\u00a0\u00a0\u00a0\u00a0', editor.model.document.selection.getFirstPosition());
		});
	}, { priority: 'high' });

	return editor;
});


if (document.querySelector('#description-editor')) {
    const descConfig = Object.assign({}, editorConfig);
    descConfig.root = {
        placeholder: 'Mô tả ngắn gọn về bài viết...',
        element: document.querySelector('#description-editor'),
    };
    descConfig.toolbar = {
        items: [
            'undo', 'redo', '|', 'heading', '|', 'bold', 'italic', 'link'
        ]
    };
    
    DecoupledEditor.create(descConfig).then(editor => {
        const container = document.querySelector('#description-editor').parentNode;
        container.insertBefore(editor.ui.view.toolbar.element, document.querySelector('#description-editor'));
        
        const form = document.querySelector('#description-editor').closest('form');
        if (form) {
            form.addEventListener('submit', () => {
                document.querySelector('#description').value = editor.getData();
            });
        }
    }).catch(error => console.error(error));
}

