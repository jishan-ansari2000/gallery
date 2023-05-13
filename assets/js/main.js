function show_updateImage_input(id) {
  let target_form = $("#" + id + " .image_title_form");
  let target_p = $("#" + id + " .image_title");

  $(".image_title_form").removeClass("editing");
  $(".image_title").removeClass("editing");

  target_form.addClass("editing");
  target_p.addClass("editing");
}


function submit_update_image(id) {
  console.log(id);

  var formData = {
    update_image: "update_image",
    id: $(`#${id} input[name=image_id]`).val(),
    image_name: $(`#${id} input[name=image_name]`).val(),
  };

  console.log(formData);

  $.ajax({
    type: "POST",
    url: "controllers/image_handler.php",
    data: formData,
  }).done(function (data) {
    
    let obj = $.parseJSON(data);
    console.log(obj);
    if(obj.status === "success") {
      let target_p = $("#" + id + " .image_title");
      target_p.text(obj.image_name);
      
      console.log(obj.image_name);
      $(".image_title_form").removeClass("editing");
      $(".image_title").removeClass("editing");

    }

  });
}

// $(document).ready(function () {
//     $(".image_title_form").submit(function (event) {
//         event.preventDefault();

//       var formData = {
//         update_image: "update_image",
//         id: $("input[name=image_id]").val(),
//         image_name: $("input[name=image_name]").val(),
//       };

//       console.log(formData);

//     });
//   });
