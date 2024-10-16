jQuery(document).ready(function ($) {
  let page = loadmore_params.current_page;

  $("#load-more").on("click", function () {
    const $loadMoreButton = $(this);
    const perpage = $loadMoreButton.data("perpage");
    const showFeaturedImage = $loadMoreButton.data("show_featured_image");

    // Increment the page number
    page++;

    // Create and show the spinner
    const $spinner = $('<div class="spinner"></div>');
    $loadMoreButton.prop("disabled", true).text("Loading...").append($spinner);

    // AJAX request to load more posts
    $.ajax({
      url: loadmore_params.ajaxurl,
      type: "POST",
      data: {
        action: "load_more_posts",
        page: page,
        perpage,
        showFeaturedImage: showFeaturedImage,
      },
      beforeSend: function () {
        $loadMoreButton.prop("disabled", true); 
      },
      success: function (response) {
        if (response) {
          $("#cp_container").append(response); // Append new posts
        } else {
          $loadMoreButton.hide(); // Hide button if no more posts
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error loading posts:", textStatus, errorThrown); // Log error for debugging
        alert("An error occurred while loading more posts. Please try again.");
      },
      complete: function () {
        $loadMoreButton.prop("disabled", false).text("Load More"); 
        $spinner.remove(); 
      },
    });
  });
});
