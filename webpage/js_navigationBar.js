function validateFormModUser() {
	var a = document.getElementById("modif").oldPassword.value;
	var b = document.getElementById("modif").newPassword.value;
	var c = document.getElementById("modif").confirmPassword.value;
	if (b != c) {
		alert("Les deux mots de passe doivent être égaux");
		document.getElementById("modif").newPassword.focus();
		return;
	} else if ((a == b) && (b != "")) {
		alert("Le nouveau mot de passe doit être différent de l'actuel");
		document.getElementById("modif").newPassword.focus();
		return;
	}
	document.getElementById("modif").submit();
}
