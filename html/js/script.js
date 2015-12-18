"use strict";

function loader() {
    return '<img src="img/ajax-loader.gif" class="devoops-getdata img-responsive col-centered" alt="preloader" />';
}

/*-------------------------------------------
 Algumas validações
 ---------------------------------------------*/
function validaSenha(pass1, pass2, qtde) {
    var p1 = document.getElementById(pass1);
    var p2 = document.getElementById(pass2);
    //TODO: alterar de alert para popup
    if (p1.value.length < qtde) {
        alert('Tamanho mínimo da senha deve ser ' + qtde);
        return false;
    }
    if (p1.value !== p2.value) {
        alert('As senhas são diferentes');
        return false;
    }
    return true;
}

function validaVazio(campo, min, max) {
    var c = document.getElementById(campo);
    if (min != 0) {
        if (c.value == '') {
            alert('Campo não pode ser vazio');
            return false;
        }
        if (c.value.length < min) {
            alert('Tamanho mínimo é de ' + min + ' caracteres');
            return false;
        }
        if (c.value.length > max) {
            alert('Tamanho máximo é de ' + max + ' caracteres');
            return false;
        }
        return true;
    }
}

function validaEmail(campo) {
    var texto = $.trim($("#" + campo).prop('value'));
    if (texto !== "") {
        var filtro = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        if (filtro.test(texto)) {
            return true;
        } else {
            alert("Endereço de email inválido!");
            return false;
        }
    } else {
        alert("Digite um email!");
        return false;
    }
}

function validaDominio(campo) {
    var texto = $.trim($("#" + campo).prop('value'));
    if (texto !== "") {
        var filtro = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
        if (filtro.test(texto)) {
            return true;
        } else {
            alert("Domínio inválido!");
            return false;
        }
    } else {
        alert("Digite um domínio!");
        return false;
    }
}

//validar IP
function valida_ip(ip) {
    var error = true;
    if (ip.match(/^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/)) {
        var _ip = ip.split('.');
        $.each(_ip, function (key, value) {
            if (parseInt(value) > 255) {
                error = false;
                return;
            }
        });
    } else {
        error = false;
    }
    return error;
}

//validar Rede
function valida_rede(ip) {
    var error = true;
    if (ip.match(/^(?:[0-9]{1,3}\.){2}[0-9]{1,3}$/)) {
        var _ip = ip.split('.');
        $.each(_ip, function (key, value) {
            if (parseInt(value) > 255) {
                error = false;
                return;
            }
        });
    } else {
        error = false;
    }
    return error;
}

/* funcoes de uso geral */

function remove_alert() {
    $('.input-required').removeClass('input-text-error').addClass('input-text-border');
    $('i').each(function () {
        if ($(this).hasClass('glyphicon-remove') || $(this).hasClass('glyphicon-ok')) {
            fechar_alert($(this));
        }
    });
}

function fechar_alert(the_alert) {
    the_alert.addClass('hidden');
}

function find_duplicates(arr) {
    var len = arr.length,
            out = [],
            counts = {};
    for (var i = 0; i < len; i++) {
        var item = arr[i];
        counts[item] = counts[item] >= 1 ? counts[item] + 1 : 1;
    }
    for (var item in counts) {
        if (counts[item] > 1)
            out.push(item);
    }
    return out;
}