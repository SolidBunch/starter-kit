import Model from './Model';
import Utils from './Helper/Utils';

/**
 * Block editor handlers
 */
export default class Handlers {

  static onChangeImage(media, props, breakpoint = null) {

    return new Promise((resolve) => {
      if (media.id) {
        resolve(media);
      } else {
        const waitForData = setInterval(() => {
          if (media.id) {
            clearInterval(waitForData);
            resolve(media);
          }
        }, 100); // reload 100
      }
    }).then((fullMedia) => {

      const {attributes, setAttributes} = props;
      const srcSetObj = {...attributes.srcSet};
      const hideBiggerBreakpoints = attributes.hideBiggerBreakpoints || true;

      let image = {
        id: fullMedia.id,
        url: fullMedia.url,
        width: fullMedia.media_details ? fullMedia.media_details.width : fullMedia.width,
        height: fullMedia.media_details ? fullMedia.media_details.height : fullMedia.height,
      };
      image.ratio = image.width / image.height;
      image.startWidth =  image.width;

      if (breakpoint) {

        Model.setBreakpoint(image, srcSetObj, breakpoint, setAttributes);

        return;
      }

      image = Utils.getDimensionHiDPI(image, attributes.hidpi, true);

      Model.setMainImage(image, setAttributes);

      Model.setSrcSet(image, srcSetObj, hideBiggerBreakpoints, setAttributes);

    }).catch((error) => {
      // eslint-disable-next-line no-console
      console.error("Errors:", error);
    });
  };

  static onChangeHiDPI(checked, props) {

    const {attributes, setAttributes} = props;
    const srcSetObj = {...attributes.srcSet};
    const hideBiggerBreakpoints = attributes.hideBiggerBreakpoints || true;

    let image = attributes.mainImage;

    console.log(image);

    image = Utils.getDimensionHiDPI(image, checked);

    Model.setMainImage(image, setAttributes);
    Model.setSrcSet(image, srcSetObj, hideBiggerBreakpoints, setAttributes);

    setAttributes({hidpi: checked});
  }

  // letter protection
  static onWidthInputKeyPress(event) {
    const allowedCharacters = /[0-9]/;
    if (!allowedCharacters.test(event.key)) {
      event.preventDefault();
    }
  };

  //"Loss of focus on input"
  static onWidthInputBlur(event, breakpoint = null) {
    const {mainImage, srcSet} = attributes;

    if (event.target.value === "") {
      if (breakpoint === null) {
        const {startWidth, ratio} = mainImage;
        const newHeight = Math.trunc(startWidth / ratio);
        Model.changeDimension('mainImage', null, {width: startWidth, height: newHeight});
      } else {
        const {startWidth, viewPort, ratio, id} = srcSet[breakpoint];
        const idValidation = mainImage.id === id;

        let newWidth = (!idValidation && startWidth <= viewPort) ? startWidth : viewPort;
        const newHeight = Math.trunc(newWidth / ratio);
        Model.changeDimension('srcSet', breakpoint, {width: newWidth, height: newHeight});
      }
    }
  };

  //change Width and Height in mainImage or srcSet
  static onWidthInputChange(event, breakpoint) {
    let newWidth = parseInt(event.replace(/\D/g, ''), 10);
    if (isNaN(newWidth)) {
      newWidth = "";
    }

    const {startWidth, ratio, id} = breakpoint ? attributes.srcSet[breakpoint] : attributes.mainImage;
    const idValidation = breakpoint ? attributes.mainImage.id === id : true;

    if (!idValidation) {
      if (newWidth > startWidth) {
        newWidth = startWidth;
      }
    } else if (newWidth > attributes.mainImage.startWidth) {
      newWidth = attributes.mainImage.startWidth;
    }
    let newHeight = Math.trunc(newWidth / ratio);

    if (breakpoint) {
      Model.changeDimension('srcSet', breakpoint, {width: newWidth, height: newHeight});
    } else {
      Model.changeDimension('mainImage', null, {width: newWidth, height: newHeight});
    }
  };

  //reset attributes to Default (Main Image)
  static onResetImage(breakpoint) {
/*    setAttributes({
      srcSet: {
        ...attributes.srcSet,
        [breakpoint]: {
          ...attributes.srcSet[breakpoint],
          imageUrl: attributes.mainImage.src,
          id: attributes.mainImage.id,
          startWidth:'',
          ratio:attributes.mainImage.ratio,
          width:attributes.srcSet[breakpoint].viewPort,
          height: Math.trunc(attributes.srcSet[breakpoint].viewPort / attributes.mainImage.ratio),
        }
      }
    });*/
  };

}
