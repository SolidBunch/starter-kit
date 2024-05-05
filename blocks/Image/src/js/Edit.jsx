import Handlers from './Handlers';
import Utils from './Helper/Utils';

/**
 * Internal block libraries
 */
const {InspectorControls, useBlockProps, MediaPlaceholder} = wp.blockEditor;
const {PanelBody, SelectControl, CheckboxControl, TextControl, TextareaControl, TabPanel} = wp.components;
const {useState} = wp.element;

/**
 * Block editor class
 */
export default class Edit {

  /**
   * Render Controls(Sidebar in right part) in Editor
   *
   * @param {Object} props
   *
   * @return {JSX.Element}
   */
  static renderControls(props) {

    const {attributes, setAttributes} = props;

    const [priorityText, setPriorityText] = useState(Utils.getPriorityText(attributes.fetchPriority));

    return (
      <InspectorControls key="controls">
        <PanelBody title="Image Properties" className="image_container">
          <TabPanel className="custom_tab" activeClass="btn-secondary text-white" tabs={[
            {
              name: 'responsive-tab',
              title: 'Responsive',
              className: 'col btn btn-sm btn-outline-secondary',
            },
            {
              name: 'settings-tab',
              title: 'Settings',
              className: 'col btn btn-sm btn-outline-secondary',
            },
          ]}>
            {(tab) => (
              <div className="custom_panel">
                {tab.name === 'responsive-tab' &&
                  <div className="pt-4">
                    {!attributes.mainImage.url ? (
                      <div className="px-3">
                        <div className="row_image">
                          <div className="setting_box">
                            <MediaPlaceholder
                              icon="format-image"
                              labels={{title: 'Add Image'}}
                              onSelect={(media) => Handlers.onChangeImage(media, props)}
                            />

                          </div>
                        </div>
                      </div>
                    ) : (
                      <div>
                        <div className="px-4 mb-5">
                          <div className="row_image">
                            <div className="setting_box">
                              <div className="img_holder">
                                <img src={attributes.mainImage.url} alt="Main"/>
                              </div>
                              <MediaPlaceholder
                                labels={{title: 'Main Image'}}
                                onSelect={(media) => Handlers.onChangeImage(media, props)}
                              />
                              <CheckboxControl
                                className="pb-3"
                                label="HiDPI"
                                checked={attributes.hidpi}
                                onChange={
                                  (checked) => Handlers.onChangeHiDPI(checked, props)
                                }
                              />
                              <div className="image-dimensions row g-2">
                                <TextControl
                                  label="width"
                                  type="number"
                                  className="col"
                                  value={Utils.getImageWidth(attributes, '', true)}
                                  placeholder={attributes.mainImage.startWidth}
                                  onKeyPress={Handlers.onNumberInputKeyPress}
                                  onChange={(event) => Handlers.onWidthInputChange(event, props)}
                                  inputMode="numeric"
                                  min="0"
                                  max={attributes.mainImage.startWidth}
                                />

                                <TextControl
                                  label="height"
                                  type="text"
                                  className="col"
                                  value={Utils.getImageHeight(attributes)}
                                  disabled
                                />

                              </div>
                            </div>
                          </div>
                        </div>
                        {Object.keys(attributes.srcSet)
                          .reverse()
                          .map((breakpoint) => (
                            // hide breakpoints, when image with < breakpoint viewPort
                            attributes.srcSet[breakpoint].enabled ? (
                              <PanelBody
                                title={`SrcSet: ${breakpoint.toUpperCase()} : ${attributes.srcSet[breakpoint].viewPort}px`}
                                key={breakpoint}
                                initialOpen={false}
                              >
                                <div className="row_image" key={breakpoint}>
                                  <div className="setting_box">
                                    <div className="img_holder">
                                      <img src={attributes.srcSet[breakpoint].url
                                        ? attributes.srcSet[breakpoint].url
                                        : attributes.mainImage.url} alt={`Breakpoint ${attributes.srcSet[breakpoint].viewPort}`}/>
                                    </div>
                                    <MediaPlaceholder
                                      labels={{title: 'Change Image'}}
                                      onSelect={(media) => Handlers.onChangeImage(media, props, breakpoint)}
                                    />
                                    {attributes.srcSet[breakpoint].id && (
                                      <button
                                        className="btn btn-danger btn-sm btn_reset"
                                        onClick={() => Handlers.onResetImage(breakpoint, props)}
                                      >
                                        Reset to Default Image
                                      </button>
                                    )}
                                    <div className="image-dimensions row g-2">
                                      <TextControl
                                        label="width"
                                        type="number"
                                        className="col"
                                        value={Utils.getImageWidth(attributes, breakpoint, true)}
                                        placeholder={attributes.srcSet[breakpoint].startWidth ? attributes.srcSet[breakpoint].startWidth : attributes.srcSet[breakpoint].viewPort}
                                        onKeyPress={Handlers.onNumberInputKeyPress}
                                        onChange={(event) => Handlers.onWidthInputChange(event, props, breakpoint)}
                                        inputMode="numeric"
                                        min="0"
                                        max={attributes.srcSet[breakpoint].startWidth ? attributes.srcSet[breakpoint].startWidth : attributes.srcSet[breakpoint].viewPort}
                                      />

                                      <TextControl
                                        label="height"
                                        type="text"
                                        className="col"
                                        value={Utils.getImageHeight(attributes, breakpoint)}
                                        disabled
                                      />
                                    </div>
                                  </div>
                                </div>
                              </PanelBody>
                            ) : null
                          ))}

                      </div>
                    )}
                  </div>
                }
                {tab.name === 'settings-tab' &&
                  <div className="pt-4 px-3">
                    <TextareaControl
                      label="Alt Text"
                      value={attributes.altText}
                      onChange={(value) => {
                        setAttributes({
                          altText: value,
                        });
                      }}
                    />
                    <CheckboxControl
                      label="Lazy Loading"
                      checked={attributes.loadingLazy}
                      onChange={(checked) => setAttributes({loadingLazy: checked})}
                    />
                    <SelectControl
                      label="Fetch Priority"
                      value={attributes.fetchPriority}
                      options={[
                        {label: 'Priority: Auto', value: 'auto'},
                        {label: 'Priority: Low', value: 'low'},
                        {label: 'Priority: High', value: 'high'},
                      ]}
                      onChange={(value) => {
                        setAttributes({fetchPriority: value});
                        setPriorityText(Utils.getPriorityText(value));
                      }}
                    />
                    <div>
                      {priorityText && <p>{priorityText}</p>}
                    </div>
                  </div>
                }
              </div>
            )}
          </TabPanel>
        </PanelBody>
      </InspectorControls>
    );
  };

  /**
   * Render Output Image in Left Part from Editor (image or placeHolder for loading image)
   *
   * @param {Object} props
   *
   * @return {JSX.Element}
   */
  static renderOutput(props) {

    const {attributes, className} = props;

    const blockProps = useBlockProps({
      className: [className],
    });

    const mainImage = attributes.mainImage;

    return (
      <>
        {mainImage.id ? (
          <figure   {...blockProps} key="blockControls">
            <img
              className={attributes.imageClass}
              src={mainImage.url}
              alt={attributes.altText}
              width={Utils.getImageWidth(attributes)}
              height={Utils.getImageHeight(attributes)}
              loading={attributes.loadingLazy ? 'lazy' : 'eager'}
              data-fetch-priority={attributes.fetchPriority}
            />
          </figure>
        ) : (
          <MediaPlaceholder
            icon="format-image"
            labels={{title: 'Add Image'}}
            onSelect={(media) => Handlers.onChangeImage(media, props)}
          />
        )}

      </>
    );
  };
}
