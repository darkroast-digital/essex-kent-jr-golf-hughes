// *************************************************************************
// *************************************************************************
// *************************************************************************

require('./bootstrap');



// #ACCODION
// =========================================================================

$('.accordion__content').hide();
$('.accordion__content').first().show();
$('.accordion__panel').first().addClass('is--open');

$('.accordion__title').click(function() {
    $('.accordion__panel').removeClass('is--open');
    $(this).parent().addClass('is--open');
    $('.accordion__content').slideUp(200);
    $(this).next('.accordion__content').slideDown(200);
});



// #TABS
// =========================================================================

$('li[data-tab], .tabs__content').first().addClass('is--active');
$('.tabs__content').first().addClass('is--active');

$('li[data-tab]').click(function() {
    var thisTab = $(this).attr('data-tab');
    var tab = $('.tabs__content' + '[data-tab="' + thisTab + '"]');

    $('li[data-tab]').removeClass('is--active');
    $(this).addClass('is--active');
    $('.tabs__content').removeClass('is--active');
    tab.addClass('is--active');
});




// #DROPDOWN
// =========================================================================

$('.dropdown__container').mouseenter(function() {
    $(this).addClass('is--active');
});

$('.dropdown__container').mouseleave(function() {
    $(this).removeClass('is--active');
});

$('.dropdown').mouseleave(function() {
    $(this).parent().removeClass('is--active');
});




// #ALERT NOTIFY
// =========================================================================

$('.alert--notify').click(function() {
    $(this).fadeOut(200);
});



// #OFF CANVAS
// =========================================================================

var offCanvasTrigger = document.querySelector('.off-canvas__trigger');
var offCanvas = document.querySelector('.off-canvas');

if (offCanvasTrigger) {
    offCanvasTrigger.addEventListener('click', function () {
        offCanvas.classList.add('is--open');
        overlay.classList.add('is--active');
    });
}

var adminOffCanvasTrigger = document.querySelector('.admin-off-canvas__trigger');
var adminOffCanvas = document.querySelector('.admin-off-canvas');

if (adminOffCanvasTrigger) {
    adminOffCanvasTrigger.addEventListener('click', function () {
        adminOffCanvas.classList.add('is--open');
        overlay.classList.add('is--active');
    });
}



// #MODAL
// =========================================================================

var modalTrigger = document.querySelector('.modal__trigger');
var modal = document.querySelector('.modal');

if (modalTrigger) {
    modalTrigger.addEventListener('click', function () {
        modal.classList.add('is--open');
        overlay.classList.add('is--active');
    });
}



// #KEY CONTROL
// =========================================================================

$(document).keyup(function(e) {
    if (e.keyCode === 27) {
        overlay.classList.remove('is--active');
    }
});

if (offCanvas) {

    $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            offCanvas.classList.remove('is--open');
        }
    });

}

if (adminOffCanvas) {

    $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            adminOffCanvas.classList.remove('is--open');
        }
    });

}

if (modal) {

    $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            modal.classList.remove('is--open');
        }
    });

}



// #OVERLAY
// =========================================================================

var overlay = document.querySelector('.overlay');

if (overlay) {
    overlay.addEventListener('click', function () {
        this.classList.remove('is--active');
    });
}

if (overlay) {
    overlay.addEventListener('click', function () {
        offCanvas.classList.remove('is--open');
    });
}

if (overlay) {
    overlay.addEventListener('click', function () {
        adminOffCanvas.classList.remove('is--open');
    });
}

if (overlay) {
    overlay.addEventListener('click', function () {
        modal.classList.remove('is--open');
    });
}



// #DOCS
// =========================================================================


// smooth scroll

$('a[href^="#"]').on('click', function(event) {
    var target = $(this.getAttribute('href'));
    if( target.length ) {
        event.preventDefault();
        $('html, body').stop().animate({
            scrollTop: target.offset().top
        }, 1000);
    }
});


// email form
var form = $('.form');

$(form).submit(function(e) {
  e.preventDefault();

  var formData = new FormData($(this)[0]);

  //if files => formData.append('file', $('input[type=file]')[0].files[0]);

  $.ajax({
    type: 'post',
    url: $(this).attr('action'),
    data: formData,
    processData: false,
    contentType: false
  })
  .done(function (response) {
    $('input').val('');
    $('textarea').val('');
    $('<div class="alert is-success">Your Message Was Sent! We\'ll be in touch.</div>').insertAfter(form);
    
    console.log('success' + response);
  })
  .fail(function (data) {
    $('input').val('');
    $('textarea').val('');
    $('<div class="alert is-error">Oh no! Something went wrong, try again.</div>').insertAfter(form);
    
    console.log('fail' + data);
  })

});




// #GO BACK
// =========================================================================

$('.go-back').on('click', function() {
    window.history.back();
});




// #ALERT FADE OUT
// =========================================================================

$('.alert').delay(6000).fadeOut("slow");




// #VIEW PASSWORD
// =========================================================================

var viewPassword = document.getElementsByClassName('view-password');

if (viewPassword) {
    for (i = 0; i < viewPassword.length; i++){
        viewPassword[i].addEventListener('click', function() {
            passwordInput = this.previousElementSibling;
            if (this.classList.contains('is-active')) {
                this.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <g class="nc-icon-wrapper" fill="#A9BFD6">
            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"></path>
        </g>
    </svg>`;
                this.classList.remove('is-active');
                passwordInput.setAttribute('type', 'password');
            } else {
                this.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <g class="nc-icon-wrapper" fill="#A9BFD6">
            <path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"></path>
        </g>
    </svg>`;
                this.classList.add('is-active');
                passwordInput.setAttribute('type', 'text');
            }
        });
    }
}




// #IMAGE PREVIEW
// =========================================================================

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.image-preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$('.image-upload input').change(function() {
    $(this).parent().find('span').hide();
    readURL(this);
    $('.image-preview').show();
})




// #SIMPLE MDE
// =========================================================================

var mde = document.getElementById('mde')

if (mde) {
    var simplemde = new SimpleMDE({ 
        element: mde,
        hideIcons: [
            'fullscreen',
            'side-by-side'
        ]
    });
}



// #TITLE AND SLUG UPDATE
// =========================================================================

$('#title').keyup(function() {
    $('#slug').val($('#title').val().replace(/\s+/g, '-').toLowerCase());
    $('#ogtitle').val($('#title').val());
});




// #DELETE CONFIRM MODAL
// =========================================================================

$('.delete').on('click', function(){
    var name = $(this).data('name');
    var id = $(this).data('id');
    $('.item-name').text(name);
    $('.hidden-input').val(id);
    var formAction = $('.delete-form').attr('action');
    $('.delete-form').attr('action', formAction + id);

    $('.delete-modal').addClass('is--active');
    $('.modal-cover').addClass('is--blurred');
    $('.admin-header').addClass('is--blurred');
    $('.admin-sidebar').addClass('is--blurred');
    $('body').css('overflow', 'hidden');
});

$('.close').on('click', function(){    
    $('.delete-modal').removeClass('is--active');
    $('.modal-cover').removeClass('is--blurred');
    $('.admin-header').removeClass('is--blurred');
    $('.admin-sidebar').removeClass('is--blurred');
    $('body').css('overflow', 'scroll');
});




$('.hidden-tournaments').hide();
$('.hidden-players').hide();

$('.agegroups').on('change', function(){
    var holes = $(this).val();

    axios.get(`http://localhost:3000/admin/scores/api/tournaments/${holes}`)
    .then(response => {
        let data = response.data;
        let template = '<option disabled selected>Select Tournament</option>';
        let i = 1;

        data.forEach(tournament => {
            
            let option = `
                <option value="${tournament.id}">Tournament ${i} - ${tournament.name}</option>
            `
            i++
            template += option
        })

        $('.js-tournaments').html(template);
        $('.hidden-tournaments').show();
    });
});



$('.agegroups').on('change', function(){

    var group = $(this).find(':selected').attr('data-group');

    axios.get(`http://localhost:3000/admin/scores/api/players/${group}`)
    .then(response => {
        let data = response.data;
        let template = '<option disabled selected>Select Player</option>';

        data.forEach(player => {
            
            let option = `
                <option value="${player.id}">${player.lname}, ${player.fname}</option>
            `
            template += option
        })

        $('.js-players').html(template);
    })
})


$('.js-tournaments').on('change', function(){
    $('.hidden-players').show();
})


$('.js-players').on('change', function(){

    var player = $(this).val();
    var tournament = $('.js-tournaments').find(':selected').val();
    var holes = $('.agegroups').find(':selected').val();

    axios.get(`http://localhost:3000/admin/scores/api/scores/${player}/${tournament}`)
    .then(response => {
        let i = 1;
        let template = "";
        let data = response.data;
        console.log(data);

        for (i; i <= holes; i++) {
            let label = `<div class="field column-2"><label for="hole${i}">Hole ${i}</label>`;
            template += label;
            let value = '';

            for (a = 0; a < data.length; a++) {
                if (data[a].hole_id == i) {
                    value = data[a].score;
                }
            }

            let input = `<input type="number" name="hole${i}" value="${value}"></div>`;
            template += input;
        }

        $('.holes-wrapper').html(template);
    })

        // $('.js-players').html(template);

})



//players filter
var catButtons = document.getElementsByClassName('cat-button');

for (var i = 0; i < catButtons.length; i++) {
  catButtons[i].addEventListener('click', function(){
    $('button.is--active').removeClass('is--active');
    $(this).addClass('is--active');
  })
}

$('button[data-category]').click(function() {
  var thisButton = $(this).attr('data-category');
  var players = document.getElementsByClassName('all');

  for (var a = 0; a < players.length; a++) {
    $(players[a]).hide();
    if (!$(players[a]).hasClass(thisButton)) {
      $(players[a]).css('display', 'none');
    } else {
      $(players[a]).fadeIn('slow');
      $(players[a]).css('display', 'block');

    }
  }
});