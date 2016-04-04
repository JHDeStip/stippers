/**
 * This file is part of the Stippers project (available here: https://github.com/Stannieman/stippers/).
 * The license and all terms en conditions that apply to Stippers also apply to this file.
 * 
 * @author Stan Wijckmans
 * 
 * This file contains code to validate a form.
 */

function validateUserDataFormPassword(form) {
    var errorMessage;
    var inputElement;
    var valid = true;

    inputElement = form.password;
    if (inputElement.value.length < PASSWORD_MIN_LENGTH) {
        element = document.getElementById('form_label_error_password');
        if (!element) {
            errorMessage = document.createElement('label');
            errorMessage.setAttribute('class', 'form_label_error');
            errorMessage.setAttribute('for', 'password');
            errorMessage.setAttribute('id', 'form_label_error_password');
            errorMessage.appendChild(document.createTextNode('Je wachtwoord moet minstens '+PASSWORD_MIN_LENGTH+' karakters lang zijn.'));
            inputElement.parentNode.insertBefore(errorMessage, inputElement.nextSibling);
        }
        else {
            element.innerHTML = 'Je wachtwoord moet minstens '+PASSWORD_MIN_LENGTH+' karakters lang zijn.';
        }
        valid = false;
    }
    else {
        element =  document.getElementById('form_label_error_password');
        if (element) {
            element.parentNode.removeChild(element);
        }
    }

    inputElement = form.repeat_password;
    if (inputElement.value != form.password.value) {
        element = document.getElementById('form_label_error_repeat_password');
        if (!element) {
            errorMessage = document.createElement('label');
            errorMessage.setAttribute('class', 'form_label_error');
            errorMessage.setAttribute('for', 'repeat_password');
            errorMessage.setAttribute('id', 'form_label_error_repeat_password');
            errorMessage.appendChild(document.createTextNode('De twee wachtwoordvelden moeten gelijk zijn.'));
            inputElement.parentNode.insertBefore(errorMessage, inputElement.nextSibling);
        }
        else {
            element.innerHTML = 'De twee wachtwoordvelden moeten gelijk zijn.';
        }
        valid = false;
    }
    else {
        element =  document.getElementById('form_label_error_repeat_password');
        if (element) {
            element.parentNode.removeChild(element);
        }
    }

    return valid;
}