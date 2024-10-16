jQuery(document).ready(function ($) {
    let mediaUploader;
  
    // Function to initialize media uploader
    const initMediaUploader = () => {
      // Create a new media uploader
      mediaUploader = wp.media({
        title: "Choose Image",
        button: {
          text: "Choose Image",
        },
        multiple: false,
      });
  
      // When an image is selected, run a callback
      mediaUploader.on("select", function () {
        const attachment = mediaUploader.state().get("selection").first().toJSON();
        $("#meta-image").val(attachment.url);
        $("#meta-image-preview").attr("src", attachment.url);
      });
    };
  
    $("#meta-image-button").on("click", function (e) {
      e.preventDefault();
  
      // If the media uploader exists, open it
      if (mediaUploader) {
        mediaUploader.open();
        return;
      }
  
      // Initialize the media uploader
      initMediaUploader();
      mediaUploader.open();
    });
  });
  