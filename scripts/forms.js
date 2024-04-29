// controle de saisie , chaque formulaire a son propre fonction

//formulaire 1
function validEmail(email){
	const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	return pattern.test(email);
}

function validNomPrenom(x){
	const pattern = /^[A-Za-z]+(?:\s[A-Za-z]+)+$/;
	return pattern.test(x);
}

function numtelValide(n){
    const pattern = /^(9|5|4|2)\d{7}$/;
    return pattern.test(n);
}

function infoPersoValide(){
	let email = document.getElementsByName("email")[0].value;
	let nompren = document.getElementsByName("nom_pren")[0].value;
	let age = document.getElementsByName("date_naiss")[0].value;
    let num_tel = document.getElementsByName("num_tel")[0].value;

	if(!validEmail(email)){
		alert("Addresse email invalid");
	}
	else if(!validNomPrenom(nompren)){
		alert("Saisir nom et prénom");
	}
    else if(!numtelValide(num_tel)){
		alert("numéro de téléphone doit étre 8 chiffres et commence par (9,5,4,2)");
	}
	else if(age == ""){
		alert("entrer votre date de naissance");
	}
    else if(new Date(age) > new Date()){
        alert("date naissance est au futur ?!");
    }
    else{
        return true;
    }
	return false;
}

//formulaire 2
function dateValide(){
	let date = document.getElementsByClassName("date");
	let duree = document.getElementsByClassName("duree");
    let dateAujordui = new Date();
    let user_date_loc = document.getElementsByName("date_loc")[0].value;
    let user_heure_loc = document.getElementsByName("heure_loc")[0].value;
    let user_date_ret = document.getElementsByName("date_ret")[0].value;
    let user_heure_ret = document.getElementsByName("heure_ret")[0].value;
    let user_full_loc_date = new Date(user_date_loc+"T"+user_heure_loc);
    let user_full_ret_date = new Date(user_date_ret+"T"+user_heure_ret);
	if(date[0].value == ""){
        alert("choisir date de location !");
	}
	else if(date[0].value.split("-")[0].length != 4){
        alert("anneé de location invalide");
	}
	else if(duree[0].value == ""){
        alert("choisir duree de location");
	}
	else if(date[1].value == ""){
        alert("choisir date de retour !");
	}
	else if(date[1].value.split("-")[0].length != 4){
        alert("anneé de retour invalide");
	}
	else if(duree[1].value == ""){
        alert("choisir duree de retour");
	}
	else if(date[0].value > date[1].value || ((date[0].value == date[1].value) && (duree[0].value > duree[1].value))){
        alert("date retour doit étre supérieur au date de location");
	}
    else if (user_full_loc_date < dateAujordui){
        alert("date location est en passé , changer le !");
    }
    else if(user_full_ret_date < dateAujordui){
        alert("date retour est en passé , changer le !");
    }
	else{
        base = 5
		rate = 0.1
		difference = new Date(date[1].value+"T"+duree[1].value) - new Date(date[0].value+"T"+duree[0].value)
		var heures = difference / (1000 * 60 * 60);
		prix_total = Math.round(base + (heures * rate));
		document.getElementById("prix").innerHTML = " "+ prix_total + " TND";
        document.getElementById("hiddenSpanValue").value = prix_total;
		return true;
	}
	
	return false;
}

function detailValide(){
	return true
}

function paiementValide(){
	let methode = document.getElementsByName("paiement");
	if (methode[0].checked){
		let num_carte = document.getElementsByName("num_carte")[0].value;
		let code_conf = document.getElementsByName("code-conf")[0].value;
		if(num_carte.length != 12)
		{
			alert("numéro de carte invalide");
			return false;
		}
		else if(code_conf.length != 4){
			alert("code confidentielle invalide");
			return false;
		}
		else{
			return true;
		}
	}
	else if(methode[1].checked){
		return true
	}
	else{
		alert("Vous devez choisir une méthode de paiement");
		return false;
	}
}

// vérifier a chaque étape si les données sont valides ou pas en faisant appel au fonction correspondante au formulaire courant
function validateAndProceed() {
    var FieldsetCourant = document.querySelector('fieldset:not([style*="none"])');
    var IndiceFieldsetCourant = Array.from(document.querySelectorAll('fieldset')).indexOf(FieldsetCourant);
    switch (IndiceFieldsetCourant) {
        case 0:
            currentStepIsValid = infoPersoValide();
            break;
        case 1:
            currentStepIsValid = dateValide();
            break;
        case 2:
            currentStepIsValid = detailValide();
            break;
    }
    // If current step is valid, proceed to the next step
    if (currentStepIsValid) {
		return true;
    }
}










//controle sur le paiement
$("#ED-lbl").click(function(){
	$("#credentials").show();
})
$("#cash-lbl").click(function(){
	$("#credentials").hide();
})

// basculement de formulaire d'une etape a autre
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches
$(".next").click(function(){
    if(animating) return false;
    animating = true;
    
    // Validate current step before proceeding
    if (!validateAndProceed()) {
        animating = false;
        return false;
    }
    
    current_fs = $(this).parent();
    next_fs = $(this).parent().next();
    
    //activate next step on progressbar using the index of next_fs
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
    
    //show the next fieldset
    next_fs.show(); 
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale current_fs down to 80%
            scale = 1 - (1 - now) * 0.2;
            //2. bring next_fs from the right(50%)
            left = (now * 50)+"%";
            //3. increase opacity of next_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({
        'transform': 'scale('+scale+')',
        'position': 'absolute'
    });
            next_fs.css({'left': left, 'opacity': opacity});
        }, 
        duration: 800, 
        complete: function(){
            current_fs.hide();
            animating = false;
        }, 
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
    });
});

$(".previous").click(function(){
    if(animating) return false;
    animating = true;
    
    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();
    
    //de-activate current step on progressbar
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
    
    //show the previous fieldset
    previous_fs.show(); 
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale previous_fs from 80% to 100%
            scale = 0.8 + (1 - now) * 0.2;
            //2. take current_fs to the right(50%) - from 0%
            left = ((1-now) * 50)+"%";
            //3. increase opacity of previous_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({'left': left});
            previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
        }, 
        duration: 800, 
        complete: function(){
            current_fs.hide();
            animating = false;
        }, 
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
    });
});

