var isPasswordValid = false;
var isUsernameValid = false;
var btnSaveUser = document.getElementById("saveUser");

function enableDisableSaveButton () {
    if (isPasswordValid == true && isUsernameValid == true) {
        btnSaveUser.disabled = false;
    } else {
        btnSaveUser.disabled = true;
    }
}

function comprobarPasswords() {
    var password = document.getElementById("password")
    var passwordAgain = document.getElementById("passwordAgain");
    var btnSaveUser = document.getElementById("saveUser");

    //comprueba si las contraseñas coinciden
    if (password.value == passwordAgain.value) {
        isPasswordValid = true;
        enableDisableSaveButton();
        document.getElementById("password").style.borderColor=document.getElementById("userType").style.borderColor;
        document.getElementById("passwordAgain").style.borderColor=document.getElementById("userType").style.borderColor;
    } else {
        isPasswordValid = false;
        enableDisableSaveButton();
        document.getElementById("password").style.borderColor="#ff0000";
        document.getElementById("passwordAgain").style.borderColor="#ff0000";
    }
}

function comprobarEspacios() {
    //Selecciona el elemento a comprobar, el que esté activo (que tenga el focus)
    var elementoActivo = document.activeElement.value;

    //Verifica que el último char ingresado no sea un espacio y si así es
    //muestra un alert "alertandole" al usuario de su error
    var n = elementoActivo.search(" ");
    if (n >= 0) {
        alert("Este elemento no puede contener espacios.");
    }

    //Asigna al elemento el mismo valor quitandole el último espacio ingresado
    document.activeElement.value = elementoActivo.trim();
}

function comprobarUsername() {
    var btnSaveUser = document.getElementById("saveUser");
    var username = $("input#username").val();

    $.post("validarUsername.php", { username: username }, function (existe) {
        if (existe == "true") {
            alert("Este nombre de usuario no está disponible");
            document.getElementById("username").style.borderColor="#ff0000";
            isUsernameValid = false;
            enableDisableSaveButton();
        } else {
            isUsernameValid = true;
            enableDisableSaveButton();
            document.getElementById("username").style.borderColor=document.getElementById("userType").style.borderColor;
        };
    });
};
