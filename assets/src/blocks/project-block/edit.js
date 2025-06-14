import {
  useBlockProps,
  InspectorControls,
  InnerBlocks,
} from "@wordpress/block-editor";
import { TextControl, PanelBody } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

import "./editor.css";
import { useState, useEffect } from "@wordpress/element";
import { useSelect } from "@wordpress/data";

const Edit = ({ attributes, setAttributes }) => {
  const { title, excerpt, thumbnail, thumbnailUrl, link, id } = attributes;

  const [postId, setPostId] = useState(id);

  const project = useSelect(
    (select) => {
      if (!postId || isNaN(postId)) {
        return null;
      }

      return select("core").getEntityRecord("postType", "dm_project", postId);
    },
    [postId],
  );

  const imageUrl = useSelect(
    (select) => {
      if (!project?.featured_media) {
        return null;
      }
      return select("core").getMedia(project.featured_media);
    },
    [project?.featured_media],
  );

  useEffect(() => {
    if (!postId) return;

    if (project) {
      setAttributes({
        title: project?.title?.raw,
        excerpt: project?.excerpt?.raw,
        thumbnail: `${project?.featured_media}`,
        thumbnailUrl: imageUrl?.source_url,
        link: project?.meta?.dm_project_link,
        id: postId,
      });
    } else {
      if (id !== postId) {
        setAttributes({
          id: postId,
        });
      }
    }
  }, [project, postId, imageUrl, id]);

  let template = [];

  const onChangePostId = (value) => {
    setPostId(value);
  };

  const isLoading = postId && project === null;
  const isNotFound = postId && project === undefined;
  const hasProjectData = !!project && id && !!imageUrl?.source_url;

  if (hasProjectData) {
    template = [
      [
        "core/media-text",
        {
          mediaId: project.featured_media,
          mediaUrl: imageUrl.source_url,
          mediaType: "image",
        },
        [
          ["core/heading", { content: project.title.raw, level: 3 }],
          ["core/paragraph", { content: project.excerpt.raw }],
          [
            "core/button",
            {
              text: __("View Project", "dm-project-plugin"),
              url: project.meta?.dm_project_link,
            },
          ],
        ],
      ],
    ];
  }

  return (
    <div {...useBlockProps()}>
      <InspectorControls>
        <PanelBody>
          <TextControl
            __nextHasNoMarginBottom
            __next40pxDefaultSize
            label={__("Project Post", "dm-project-plugin")}
            value={postId}
            onChange={onChangePostId}
          />
        </PanelBody>
      </InspectorControls>

      {isLoading && (
        <div
          style={{
            display: "flex",
            alignItems: "center",
            gap: "8px",
            marginTop: "10px",
          }}
        >
          <Spinner />
          <span>{__("Loading project data...", "dm-project-plugin")}</span>
        </div>
      )}

      {hasProjectData ? (
        <InnerBlocks
          key={postId}
          allowedBlocks={["core/media-text"]}
          template={template}
          templateLock="all"
        />
      ) : (
        <div
          className="dm-project-placeholder"
          style={{
            padding: "20px",
            border: "1px dashed #ccc",
            textAlign: "center",
            minHeight: "100px",
            display: "flex",
            alignItems: "center",
            justifyContent: "center",
            fontSize: "14px",
            color: "#555",
            backgroundColor: "#f0f0f0",
          }}
        >
          {postId
            ? isNotFound
              ? __("Project ID not found.", "dm-project-plugin")
              : __(
                  "Enter a valid Project ID in the Inspector Controls.",
                  "dm-project-plugin",
                )
            : __(
                "Please enter a Project ID in the Inspector Controls to display content.",
                "dm-project-plugin",
              )}
        </div>
      )}
    </div>
  );
};

export default Edit;
