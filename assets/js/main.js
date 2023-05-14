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


$(document).ready(function () {
  $('#imageCarousel').carousel({
      interval: 1000,
      wrap: false
  })

  let prevBtn = $('.carousel-control-prev');
  let nextBtn = $('.carousel-control-next');

  prevBtn.click(function(){
    let carouselFirstChild = $('.carousel-inner .carousel-item:first-child');
    
    if (carouselFirstChild.hasClass('active')) {

      let id = carouselFirstChild.data('value');
      
      $.ajax({
        type: "POST",
        url: "controllers/image_handler.php",
        data: {
          prev_image: "next_image",
          id: id
        },
      }).done(function (data) {
        
        let obj = $.parseJSON(data);
        console.log(obj);

        if(obj.status == "success") {

          let images = obj['images'];
  
          images.sort(function(a, b) { 
            return (a.id - b.id);
          });

          $(".carousel-item").removeClass('active');

          let flag = true;

          $.each(images, function( index, value ) {

            console.log(index, value);

            let img = value['path'] + value['image_name'] + "-" + value['upload_time'] + "." + value['image_ext'];

            let str = `
              <div class="carousel-item ${flag ? 'active' : ""}"  style="height: 80vh;" data-value="${value['id']}">
                  <img src="${img}" class="d-block w-100" alt="${value['image_name']}">
                  <div class="carousel-caption d-none d-md-block">
                      <h5>${value['image_name']}</h5>
                  </div>
              </div>
            `;

            flag = false;

            $("#carousel_container").prepend(str);  //append child to carousel
          });

        } else if(obj.status == "zeroImages") {

          let str = `
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Hey! </strong> ${obj.message}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          `;

          $("#imageStatus").append(str);

          prevBtn.hide();
        }
      });

    }
    
  });

  nextBtn.click(function(){
    let carouselSecondChild = $('.carousel-inner .carousel-item:last-child');

    if (carouselSecondChild.hasClass('active')) {

      let id = carouselSecondChild.data('value');
      
      $.ajax({
        type: "POST",
        url: "controllers/image_handler.php",
        data: {
          next_image: "next_image",
          id: id
        },
      }).done(function (data) {
        
        let obj = $.parseJSON(data);

        console.log(obj);

        if(obj.status == "success") {

          let images = obj['images'];
  
          images.sort(function(a, b) { 
            return -(a.id - b.id);
          });

          $(".carousel-item").removeClass('active');

          let flag = true;
          $.each(images, function( index, value ) {

            let img = value['path'] + value['image_name'] + "-" + value['upload_time'] + "." + value['image_ext'];

            let str = `
              <div class="carousel-item ${flag ? 'active' : ""}"  style="height: 80vh;" data-value="${value['id']}">
                  <img src="${img}" class="d-block w-100" alt="${value['image_name']}">
                  <div class="carousel-caption d-none d-md-block">
                      <h5>${value['image_name']}</h5>
                  </div>
              </div>
            `;

            flag = false;

            $("#carousel_container").append(str);  //append child to carousel
          });

        } else if(obj.status == "zeroImages") {

          let str = `
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Hey! </strong> ${obj.message}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          `;

          $("#imageStatus").append(str);

          nextBtn.hide();
        }

      });

      

    }
    


  });

  $('#imageCarousel').on('slid.bs.carousel', '', function () {
      
      prevBtn.show();
      nextBtn.show();

  });

});