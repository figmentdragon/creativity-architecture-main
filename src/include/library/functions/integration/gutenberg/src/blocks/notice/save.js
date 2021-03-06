import { __ } from "@wordpress/i18n";
import { useBlockProps, RichText } from "@wordpress/block-editor";

import classnames from "classnames";

/**
 * Defines the way in which the different attributes should be combined into the final markup,
 * which is then serialized by the block editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
function save({ attributes }) {
	const { typeClassName, message, contentAlignment, id } = attributes;
	let textAlignClassName = "";

	switch (contentAlignment) {
		case "left":
			textAlignClassName = "text-left";
			break;

		case "center":
			textAlignClassName = "text-center";
			break;

		case "right":
			textAlignClassName = "text-right";
			break;

		case "justify":
			textAlignClassName = "text-justify";
			break;

		default:
			break;
	}

	const noticeClassName = classnames(
		"block block-notice notice",
		typeClassName,
		textAlignClassName
	);

	return (
		<div
			{...useBlockProps.save({
				className: noticeClassName
			})}
		>
			<RichText.Content value={message} />
		</div>
	);
}

export default save;
