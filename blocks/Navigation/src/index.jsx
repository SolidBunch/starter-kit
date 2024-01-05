/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps} = wp.blockEditor;
const {PanelBody, SelectControl, Spinner} = wp.components;
const {serverSideRender: ServerSideRender} = wp;
const {useState, useEffect} = wp.element;

registerBlockType(
  metadata,
  {
    edit: props => {
      const {attributes, setAttributes, className} = props;
      const blockProps = useBlockProps({
        className: [className],
      });

      const [menus, setMenus] = useState([]);

      useEffect(() => {
        wp.apiFetch({path: '/skt/v1/get-menus'})
          .then(fetchedMenus => {
            setMenus(fetchedMenus);
          })
          .catch(error => {
            // eslint-disable-next-line no-console
            console.error('Error fetching menus:', error);
          });
      }, []); // Empty dependency array ensures this runs only once when the component mounts

      const renderControls = (
        <InspectorControls key="controls">
          <PanelBody title="Navigation Options">
            <h1>NAV</h1>
            {menus.length < 1
              ? <Spinner key="siteSpinner"/>
              : <SelectControl
                label="Select Menu"
                value={attributes.menuId}
                options={[
                  {label: 'Select a menu', value: ''},
                  ...menus.map(menu => ({
                    label: menu.name,
                    value: menu.id,
                  })),
                ]}
                onChange={(menuId) => {
                  setAttributes({menuId});
                }}
              />
            }
          </PanelBody>
        </InspectorControls>
      );

      const renderOutput = (
        <div {...blockProps} key="blockControls">
          <ServerSideRender
            block={metadata.name}
            attributes={attributes}
          />
        </div>
      );

      return [
        renderControls,
        renderOutput,
      ];
    },
    save: () => {
      // Rendering in PHP
      return null;
    },
  },
);
