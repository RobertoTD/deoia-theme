( function( blocks, blockEditor, element, i18n ) {
    var registerBlockType = blocks.registerBlockType;
    var RichText = blockEditor.RichText;
    var useBlockProps = blockEditor.useBlockProps;
    var BlockControls = blockEditor.BlockControls;
    var AlignmentToolbar = blockEditor.AlignmentToolbar;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = window.wp.components.PanelBody;
    var RangeControl = window.wp.components.RangeControl;
    var Fragment = element.Fragment;
    var createElement = element.createElement;
    var __ = i18n.__;

    registerBlockType( 'deoia/badge', {
        apiVersion: 2,
        title: __( 'Etiqueta Deoia', 'deoia' ),
        description: __( 'Etiqueta visual corta con alineación nativa de Gutenberg.', 'deoia' ),
        icon: 'tag',
        category: 'design',
        attributes: {
            content: {
                type: 'string',
                source: 'html',
                selector: 'span.deoia-badge__label',
                default: '',
            },
            textAlign: {
                type: 'string',
                default: 'left',
            },
            fontSize: {
                type: 'number',
                default: 17,
            },
        },
        supports: {
            html: false,
            customClassName: false,
        },
        edit: function( props ) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var textAlign = attributes.textAlign || 'left';
            var fontSize = attributes.fontSize || 17;
            var blockProps = useBlockProps( {
                className: textAlign ? 'has-text-align-' + textAlign : undefined,
            } );

            return createElement(
                Fragment,
                null,
                createElement(
                    InspectorControls,
                    null,
                    createElement(
                        PanelBody,
                        {
                            title: __( 'Ajustes de etiqueta', 'deoia' ),
                            initialOpen: true,
                        },
                        createElement( RangeControl, {
                            label: __( 'Tamaño de letra', 'deoia' ),
                            value: fontSize,
                            onChange: function( nextFontSize ) {
                                setAttributes( {
                                    fontSize: nextFontSize || 17,
                                } );
                            },
                            min: 12,
                            max: 32,
                            step: 1,
                        } )
                    )
                ),
                createElement(
                    BlockControls,
                    null,
                    createElement( AlignmentToolbar, {
                        value: textAlign,
                        onChange: function( nextAlign ) {
                            setAttributes( {
                                textAlign: nextAlign || 'left',
                            } );
                        },
                    } )
                ),
                createElement(
                    'div',
                    blockProps,
                    createElement( RichText, {
                        tagName: 'span',
                        className: 'deoia-badge__label',
                        style: {
                            fontSize: fontSize + 'px',
                        },
                        value: attributes.content,
                        onChange: function( nextContent ) {
                            setAttributes( { content: nextContent } );
                        },
                        placeholder: __( 'Texto de la etiqueta', 'deoia' ),
                        allowedFormats: [],
                        withoutInteractiveFormatting: true,
                    } )
                )
            );
        },
        save: function( props ) {
            var attributes = props.attributes;
            var textAlign = attributes.textAlign || 'left';
            var fontSize = attributes.fontSize || 17;
            var blockProps = useBlockProps.save( {
                className: textAlign ? 'has-text-align-' + textAlign : undefined,
            } );

            return createElement(
                'div',
                blockProps,
                createElement( RichText.Content, {
                    tagName: 'span',
                    className: 'deoia-badge__label',
                    style: {
                        fontSize: fontSize + 'px',
                    },
                    value: attributes.content,
                } )
            );
        },
    } );
} )(
    window.wp.blocks,
    window.wp.blockEditor,
    window.wp.element,
    window.wp.i18n
);
