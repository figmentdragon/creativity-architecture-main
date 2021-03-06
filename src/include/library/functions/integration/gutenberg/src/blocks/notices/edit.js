import { __ } from "@wordpress/i18n";
import {
	BlockControls,
	useBlockProps,
	__experimentalUseInnerBlocksProps as useInnerBlocksProps,
	AlignmentToolbar,
	/**
	 * JustifyContentControl is the new cool control.
	 * It's used by core/buttons block.
	 *
	 * Unfortunately, it's causing error in our code.
	 * Even though how we use it was almost the same (if not totally the same) as in buttons block.
	 *
	 * For now, let's use AlignmentToolbar.
	 * I let the import stays here so that we might consider to move to JustifyContentControl in the future.
	 */
	JustifyContentControl,
} from "@wordpress/block-editor";

/**
 * External dependencies
 */
import classnames from "classnames";

/**
 * Internal dependencies
 */
import { name as noticeBlockName } from "../notice/editor.js";

const ALLOWED_BLOCKS = [noticeBlockName];
const NOTICES_TEMPLATE = [["themename/notice"]];

/**
 * Describes the structure of the block in the context of the editor.
 * This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
function NoticesEdit({
	attributes: { contentJustification, orientation },
	setAttributes,
}) {
	const blockProps = useBlockProps({
		className: classnames("block block-notices", {
			[`content-justified-${contentJustification}`]: contentJustification,
			"is-vertical": orientation === "vertical",
		}),
	});

	const innerBlocksProps = useInnerBlocksProps(blockProps, {
		allowedBlocks: ALLOWED_BLOCKS,
		template: NOTICES_TEMPLATE,
		orientation,
		__experimentalLayout: {
			type: "default",
			alignments: [],
		},
		templateInsertUpdatesSelection: true,
	});

	// This is related to JustifyContentControl (see @import section above).
	const justifyControls =
		orientation === "vertical"
			? ["left", "center", "right"]
			: ["left", "center", "right", "space-between"];

	return (
		<>
			<BlockControls group="block">
				<AlignmentToolbar
					value={contentJustification}
					onChange={(value) => setAttributes({ contentJustification: value })}
				/>
			</BlockControls>

			<div {...innerBlocksProps} />
		</>
	);
}

export default NoticesEdit;
