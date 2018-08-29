function med_name_remaining_character() {
    var max_length = 60;
    var character_entered = $('#med-name-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#med-name-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#med-name-character-count').css('color','#FF0000');
    } else {
    $('#med-name-character-count').css('color','#A0A0A0');
    }
}

function med_description_remaining_character() {
    var max_length = 6000;
    var character_entered = $('#med-description-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#med-description-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#med-description-character-count').css('color','#FF0000');
    } else {
    $('#med-description-character-count').css('color','#A0A0A0');
    }
}

function how_to_store_remaining_character() {
    var max_length = 255;
    var character_entered = $('#how-to-store-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#how-to-store-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#how-to-store-character-count').css('color','#FF0000');
    } else {
    $('#how-to-store-character-count').css('color','#A0A0A0');
    }
}

function how_to_take_remaining_character() {
    var max_length = 255;
    var character_entered = $('#how-to-take-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#how-to-take-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#how-to-take-character-count').css('color','#FF0000');
    } else {
    $('#how-to-take-character-count').css('color','#A0A0A0');
    }
}

function side_effects_remaining_character() {
    var max_length = 255;
    var character_entered = $('#side-effects-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#side-effects-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#side-effects-character-count').css('color','#FF0000');
    } else {
    $('#side-effects-character-count').css('color','#A0A0A0');
    }
}

function used_for_remaining_character() {
    var max_length = 255;
    var character_entered = $('#used-for-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#used-for-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#used-for-character-count').css('color','#FF0000');
    } else {
    $('#used-for-character-count').css('color','#A0A0A0');
    }
}

function short_name_remaining_character() {
    var max_length = 40;
    var character_entered = $('#short-name-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#short-name-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#short-name-character-count').css('color','#FF0000');
    } else {
    $('#short-name-character-count').css('color','#A0A0A0');
    }
}

function ratings_remaining_character() {
    var max_length = 1;
    var character_entered = $('#ratings-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#ratings-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#ratings-character-count').css('color','#FF0000');
    } else {
    $('#ratings-character-count').css('color','#A0A0A0');
    }
}

function company_id_remaining_character() {
    var max_length = 5;
    var character_entered = $('#company-name-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#company-name-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#company-name-character-count').css('color','#FF0000');
    } else {
    $('#company-name-character-count').css('color','#A0A0A0');
    }
}

function price_remaining_character() {
    var max_length = 5;
    var character_entered = $('#price-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#price-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#price-character-count').css('color','#FF0000');
    } else {
    $('#price-character-count').css('color','#A0A0A0');
    }
}

function tags_remaining_character() {
    var max_length = 255;
    var character_entered = $('#tags-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#tags-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#tags-character-count').css('color','#FF0000');
    } else {
    $('#tags-character-count').css('color','#A0A0A0');
    }
}

function type_remaining_character() {
    var max_length = 255;
    var character_entered = $('#type-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#type-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#type-character-count').css('color','#FF0000');
    } else {
    $('#type-character-count').css('color','#A0A0A0');
    }
}

function also_called_remaining_character() {
    var max_length = 255;
    var character_entered = $('#also-called-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#also-called-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#also-called-character-count').css('color','#FF0000');
    } else {
    $('#also-called-character-count').css('color','#A0A0A0');
    }
}

function available_as_remaining_character() {
    var max_length = 255;
    var character_entered = $('#available-as-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#available-as-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#available-as-character-count').css('color','#FF0000');
    } else {
    $('#available-as-character-count').css('color','#A0A0A0');
    }
}

function when_to_take_remaining_character() {
    var max_length = 255;
    var character_entered = $('#when-to-take-text-content').val().length;
    var character_remaining = max_length - character_entered;
    $('#when-to-take-character-count').html(character_remaining);
    if(max_length < character_entered) {
    $('#when-to-take-character-count').css('color','#FF0000');
    } else {
    $('#when-to-take-character-count').css('color','#A0A0A0');
    }
}