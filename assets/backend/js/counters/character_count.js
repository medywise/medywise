function username_remaining_character() {
    var max_length = 50;
    var character_entered = $('#username-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#username-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#username-character-count').css('color','#FF0000');
    } else {
    $('#username-character-count').css('color','#A0A0A0');
    }
}

function password_remaining_character() {
    var max_length = 50;
    var character_entered = $('#password-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#password-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#password-character-count').css('color','#FF0000');
    } else {
    $('#password-character-count').css('color','#A0A0A0');
    }
}

function first_name_remaining_character() {
    var max_length = 50;
    var character_entered = $('#first-name-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#first-name-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#first-name-character-count').css('color','#FF0000');
    } else {
    $('#first-name-character-count').css('color','#A0A0A0');
    }
}

function last_name_remaining_character() {
    var max_length = 50;
    var character_entered = $('#last-name-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#last-name-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#last-name-character-count').css('color','#FF0000');
    } else {
    $('#last-name-character-count').css('color','#A0A0A0');
    }
}

function email_remaining_character() {
    var max_length = 50;
    var character_entered = $('#email-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#email-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#email-character-count').css('color','#FF0000');
    } else {
    $('#email-character-count').css('color','#A0A0A0');
    }
}

function description_remaining_character() {
    var max_length = 5000;
    var character_entered = $('#description-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#description-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#description-character-count').css('color','#FF0000');
    } else {
    $('#description-character-count').css('color','#A0A0A0');
    }
}

function name_remaining_character() {
    var max_length = 50;
    var character_entered = $('#name-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#name-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#name-character-count').css('color','#FF0000');
    } else {
    $('#name-character-count').css('color','#A0A0A0');
    }
}