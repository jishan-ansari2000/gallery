let root_route = "../../";

$(document).ready(function () {
  $.ajax({
    type: "POST",
    url: `${root_route}controllers/auth.php`,
    data: {
      "get_session_during_reload": "get_session_during_reload",
    },
  }).done(function (data) {
    let obj = $.parseJSON(data);
    console.log(obj);
    if(!obj.email && !obj["404"] && obj.current_url != "/views/pages/home.php") {

      $('#loginModalToggle').modal('show');

      $('#loginModalToggle').on('hidden.bs.modal', function() {

          if (!obj.email && !$('#signupModalToggle').is(':visible')) {
              $('#loginModalToggle').modal('show');
          }
      });

      $('#signupModalToggle').on('hidden.bs.modal', function() {

          if (!obj.email) {
              $('#loginModalToggle').modal('show');
          }
      });
    }
  });
})

$("#signupForm").submit(function(e){
  e.preventDefault();

  let formData = {
    signup: "signup",
    signup_username: e.target.signup_username.value,
    signup_email: e.target.signup_email.value,
    signup_password: e.target.signup_password.value,
    signup_cpassword: e.target.signup_cpassword.value,
  };

  console.log(formData);

  $.ajax({
    type: "POST",
    url: `${root_route}controllers/auth.php`,
    data: formData,
  }).done(function (data) {
    let obj = $.parseJSON(data);
    console.log(obj);
    if (obj.status === "success") {
      window.location.href = obj["url"];
    } else if(obj.status === "failed") {
      let status_str = `
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Hey! </strong> ${obj["message"]}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `;

      $(".signupWarningContainer").html(status_str);
    }
  });
});

$("#loginForm").submit(function(e){
  e.preventDefault();

  let formData = {
    login: "login",
    login_email: e.target.login_email.value,
    login_password: e.target.login_password.value,
  };

  // console.log(formData);

  $.ajax({
    type: "POST",
    url: `${root_route}controllers/auth.php`,
    data: formData,
  }).done(function (data) {
    let obj = $.parseJSON(data);
    console.log(obj);
    if (obj.status === "success") {
      window.location.href = obj["url"];
    } else if(obj.status === "failed") {
      let status_str = `
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Hey! </strong> ${obj["message"]}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `;
      $(".loginWarningContainer").html(status_str);
    }
  });
});

function imageMouseOver(id) {
  let cardimgOverlay = $(`#${id} .card-image-overlay`);
  let cardBtnContainer = $(`#${id} .card-btn-container`);

  cardimgOverlay.css("background", "rgba(60, 60, 60, 0.4)");
  cardBtnContainer.css("display", "block");
}

function imageMouseOut(id) {
  let cardimgOverlay = $(`#${id} .card-image-overlay`);
  let cardBtnContainer = $(`#${id} .card-btn-container`);

  cardBtnContainer.css("display", "none");
  cardimgOverlay.css("background", "unset");
}

function btnMouseOver(id) {
  let cardimgOverlay = $(`#${id} .card-image-overlay`);
  let cardBtnContainer = $(`#${id} .card-btn-container`);

  cardBtnContainer.css("display", "block");
  cardimgOverlay.css("background","rgba(60, 60, 60, 0.4)");
}

function btnMouseOut(id) {
  let cardimgOverlay = $(`#${id} .card-image-overlay`);
  let cardBtnContainer = $(`#${id} .card-btn-container`);

  cardBtnContainer.css("display", "none");
  cardimgOverlay.css("background","unset");
}

function show_updateImage_input(id) {
  let target_form = $("#" + id + " .image_title_form");
  let target_p = $("#" + id + " .image_title");
  let input_field = $("#" + id + " .image_title_form input[name=image_name]");

  $(".image_title_form").removeClass("editing");
  $(".image_title").removeClass("editing");

  target_form.addClass("editing");
  target_p.addClass("editing");

  input_field.focus();

  let inputValue = input_field.val();
  input_field.val('');
  input_field.val(inputValue);

  let inputElement = input_field.get(0);
  inputElement.scrollLeft = inputElement.scrollWidth;
}

$(".image_title_form").submit(function(e){
  e.preventDefault();

  let id = e.target.image_id.value;
  let image_name = e.target.image_name.value

  let formData = {
    update_image: "update_image",
    id: id,
    image_name: image_name,
  };

  // console.log(formData);

  $.ajax({
    type: "POST",
    url: `${root_route}controllers/image_handler.php`,
    data: formData,
  }).done(function (data) {
    let obj = $.parseJSON(data);
    console.log(obj);
    if (obj.status === "success") {
      let target_p = $("#" + id + " .image_title");
      target_p.text(obj.image_name);

      console.log(obj.image_name);
      $(".image_title_form").removeClass("editing");
      $(".image_title").removeClass("editing");
    }
  });
});

$(".image_delete_form").submit(function(e){
  e.preventDefault();

  if(confirm('Are you sure you want to delete the Image')){
    let id = e.target.image_id.value;

    $.ajax({
      type: "POST",
      url: `${root_route}controllers/image_handler.php`,
      data: {
        delete_image: "delete_image",
        id: id
      },
    }).done(function (data) {
      let obj = $.parseJSON(data);
      if (obj.status === "success") {
        console.log( `#${obj.image_id}`);
        $(`#${obj.image_id}`).remove();
      }
    });
  } 
}); 

$(".bin_image_delete_form").submit(function(e){
  e.preventDefault();

  if(confirm('Are you sure you want to delete the Image')){
    let id = e.target.image_id.value;

    $.ajax({
      type: "POST",
      url: `${root_route}controllers/image_handler.php`,
      data: {
        bin_image_delete_form: "bin_image_delete_form",
        id: id
      },
    }).done(function (data) {
      let obj = $.parseJSON(data);
      if (obj.status === "success") {
        console.log( `#${obj.image_id}`);
        $(`#${obj.image_id}`).remove();
      }
    });
  } 
});

function restoreImageFun(id) {
  $.ajax({
      type: "POST",
      url: `${root_route}controllers/image_handler.php`,
      data: {
        restoreImage: "bin_image_delete_form",
        id: id
      },
    }).done(function (data) {
      let obj = $.parseJSON(data);
      if (obj.status === "success") {
        console.log(obj);
        $(`#${obj.image_id}`).remove();
      }
    });
}

// function copyLinkHandler(id) {
//   let shareLinkInput = $(`#shareLinkInput-${id}`);

//   let img = shareLinkInput.val();
//   // alert(img);

//   navigator.clipboard.writeText(img).then(function() {
//     console.log('Text copied to clipboard');
//   }, function() {
//     console.error('Failed to copy text to clipboard');
//   });

// }





//************************ * carousel start here

$(document).ready(function () {

  $("#imageCarousel").carousel({
    interval: 1000,
    wrap: false,
  });

  let prevBtn = $(".carousel-control-prev");
  let nextBtn = $(".carousel-control-next");

  let carouselFirstChild = $(".carousel-inner .carousel-item:nth-child(1)");
  let carouselLastChild = $(
    ".carousel-inner .carousel-item:last-child"
  );

  if (carouselFirstChild.hasClass("active")) {
    prevBtn.hide();
  } else if (carouselLastChild.hasClass("active")) {
    nextBtn.hide();
  }

  



  prevBtn.click(function () {
    let carouselSecondFirstChild = $(".carousel-inner .carousel-item:nth-child(2)");
    let carouselFirstChild = $(".carousel-inner .carousel-item:nth-child(1)");

    if (carouselSecondFirstChild.hasClass("active")) {
      let id = carouselFirstChild.data("value");

      $.ajax({
        type: "POST",
        url: `${root_route}controllers/image_handler.php`,
        data: {
          prev_image: "next_image",
          id: id,
        },
      }).done(function (data) {
        let obj = $.parseJSON(data);
        console.log(obj);

        if (obj.status == "success") {
          let images = obj["images"];

          images.sort(function (a, b) {
            return a.id - b.id;
          });

          // $(".carousel-item").removeClass("active");

          let flag = true;

          $.each(images, function (index, value) {
            console.log(index, value);

            let img = root_route +
              value["path"] +
              value["image_name"] +
              "-" +
              value["upload_time"] +
              "." +
              value["image_ext"];

            let str = `
              <div class="carousel-item" data-value="${value["id"]}">
                  <div class="imageCarouselCard">
                      <img src="${img}" class="d-block w-100" alt="${value["image_name"]}">
                      <p >${value["image_name"]} </p>
                  </div>
              </div>
            `;

            flag = false;

            $("#carousel_container").prepend(str); //append child to carousel
          });
        } else if (obj.status == "zeroImages") {
          // let str = `
          //   <div class="alert alert-warning alert-dismissible fade show" role="alert">
          //     <strong>Hey! </strong> ${obj.message}
          //     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          // </div>
          // `;

          // $("#imageStatus").html(str);

          prevBtn.hide();
        }
      });
    }
  });

  nextBtn.click(function () {
    let carouselSecondLastChild = $(
      ".carousel-inner .carousel-item:last-child"
    ).prev();
    let carouselLastChild = $(
      ".carousel-inner .carousel-item:last-child"
    );

    if (carouselSecondLastChild.hasClass("active")) {
      let id = carouselLastChild.data("value");

      $.ajax({
        type: "POST",
        url: `${root_route}controllers/image_handler.php`,
        data: {
          next_image: "next_image",
          id: id,
        },
      }).done(function (data) {
        let obj = $.parseJSON(data);

        console.log(obj);

        if (obj.status == "success") {
          let images = obj["images"];

          images.sort(function (a, b) {
            return -(a.id - b.id);
          });

          // $(".carousel-item").removeClass("active");

          let flag = true;
          $.each(images, function (index, value) {
            let img = root_route + value["path"] + value["image_name"] + "-" + value["upload_time"] + "." +  value["image_ext"];

            let str = `
              <div class="carousel-item" data-value="${value["id"]}">
                  <div class="imageCarouselCard">
                      <img src="${img}" class="d-block w-100" alt="${value["image_name"]}">
                      <p >${value["image_name"]} </p>
                  </div>
              </div>
            `;

            flag = false;

            $("#carousel_container").append(str); //append child to carousel
          });
        } else if (obj.status == "zeroImages") {
          // let str = `
          //   <div class="alert alert-warning alert-dismissible fade show" role="alert">
          //     <strong>Hey! </strong> ${obj.message}
          //     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          // </div>
          // `;

          $("#imageStatus").html(str);
        }
      });
    }
  });

  $("#imageCarousel").on("slid.bs.carousel", "", function () {
    prevBtn.show();
    nextBtn.show();

    let carouselFirstChild = $(".carousel-inner .carousel-item:nth-child(1)");
    let carouselLastChild = $(".carousel-inner .carousel-item:last-child");

    let currentChild = $('.carousel-item.active');

    $.ajax({
      type: "POST",
      url: `${root_route}controllers/image_handler.php`,
      data: {
        set_session_id_forurl: "set_session_id",
        image_id: currentChild.data("value")
      }
    }).done(function(data){
      console.log(data);
    })

    if (carouselFirstChild.hasClass("active")) {
      prevBtn.hide();
    } else if (carouselLastChild.hasClass("active")) {
      nextBtn.hide();
    } else {
      $("#imageStatus").html("");
    }
  });
});

  //*********************** */ carousel End here