jQuery(document).ready(function ($) {
    // Function to show modal with post content
    function showModal(response) {
      $("#modal-body").html(response);
      $("#postModal").fadeIn();
    }
  
    // Function to hide the modal
    function hideModal() {
      $("#postModal").fadeOut();
    }
  
    // Delegate event to dynamically loaded elements for post titles and thumbnails
    $(document).on("click", ".post-title, .post-thumbnail", function () {
      const postId = $(this).data("postid");
      const perpage = $(this).data("perpage");
  
      // AJAX request to get post content
      $.ajax({
        url: loadmore_params.ajaxurl,
        type: "POST",
        data: {
          action: "get_post_content",
          post_id: postId,
          perpage,
        },
        success: showModal,
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("Error fetching post content:", textStatus, errorThrown);
          alert("An error occurred while fetching the post content. Please try again.");
        },
      });
    });
  
    // Hide modal on close button click
    $(document).on("click", ".close", hideModal);
  });
  