

//  Thema

let inputfilethema = document.getElementById('inputfilethema');
let loeschenthema = document.getElementById('loeschenthema');
let bildvorschauthema = document.getElementById('Bildvorschauthema');
let themaname = document.getElementById('thema');
let speichernthema = document.getElementById('themaspeichern');
let msgboxthema = document.getElementById('messageboxthema');
themaname.addEventListener('input', ValidateDataThema)
inputfilethema.addEventListener('change', ValidateDataThema)
loeschenthema.addEventListener('click', () => {
	inputfilethema.value = null;
	bildvorschauthema.src = "/Gegneravatare/Default.png";
	fileselectedthema = false;
	speichernthema.setAttribute('disabled', 'disabled');
	msgboxthema.style.color = "red";
	msgboxthema.innerHTML = "Kein Bild ausgewählt";
}
);

function PreviewImageThema() {
	var oFReader = new FileReader();
	oFReader.readAsDataURL(document.getElementById("inputfilethema").files[0]);
	oFReader.onload = function (oFREvent) {
		document.getElementById("Bildvorschauthema").src = oFREvent.target.result;
	};
};
function ValidateDataThema() {
	if (themaname.value != "" && themaname.value.length > 0) { boolnamethema = true; } else { boolnamethema = false; }
	if (inputfilethema.files.length != 0) { fileselectedthema = true; } else { fileselectedthema = false; }

	if (boolnamethema && fileselectedthema) {
		msgboxthema.innerHTML = "Eingaben sind gültig";
		msgboxthema.style.color = "green";
		speichernthema.removeAttribute('disabled');
	}
	else {
		msgboxthema.innerHTML = "Nicht alle Felder ausgefüllt !";
		msgboxthema.style.color = "red";
		speichernthema.setAttribute('disabled', 'disabled')
	}
};

// Gegner

let inputfile = document.getElementById('inputfile');
let loeschen = document.getElementById('loeschen');
let bildvorschau = document.getElementById('Bildvorschau');
let gegnername = document.getElementById('gegnername');
let lvl = document.getElementById('lvl');
let lebenspunkte = document.getElementById('lebenspunkte');
let angriff = document.getElementById('angriff');
let geld = document.getElementById('geld');
let msgbox = document.getElementById('messagebox');
let speichern = document.getElementById('speichern');
gegnername.addEventListener('input', ValidateData)
lvl.addEventListener('input', ValidateData)
lebenspunkte.addEventListener('input', ValidateData)
gegnername.addEventListener('input', ValidateData)
angriff.addEventListener('input', ValidateData)
inputfile.addEventListener('change', ValidateData)
loeschen.addEventListener('click', () => {
	inputfile.value = null;
	bildvorschau.src = "/Gegneravatare/Default.png";
	fileselected = false;
	speichern.setAttribute('disabled', 'disabled');
	msgbox.style.color = "red";
	msgbox.innerHTML = "Kein Bild ausgewählt";
}
);

function PreviewImage() {
	var oFReader = new FileReader();
	oFReader.readAsDataURL(document.getElementById("inputfile").files[0]);
	oFReader.onload = function (oFREvent) {
		document.getElementById("Bildvorschau").src = oFREvent.target.result;
	};
};

function ValidateData() {
	if (gegnername.value != "" && gegnername.value.length > 0) { boolgegnername = true; } else { boolgegnername = false; }
	if (lvl.value != "" && lvl.value.length > 0) { boollvl = true; } else { boollvl = false; }
	if (lebenspunkte.value != "" && lebenspunkte.value.length > 0) { boollebenspunkte = true; } else { boollebenspunkte = false; }
	if (angriff.value != "" && angriff.value.length > 0) { boolangriff = true; } else { boolangriff = false; }
	if (geld.value != "" && geld.value.length > 0) { boolgeld = true; } else { boolgeld = false; }
	if (inputfile.files.length != 0) { fileselected = true; } else { fileselected = false; }

	if (boolgegnername && boollvl && boollebenspunkte && boolangriff && boolgeld && fileselected) {
		msgbox.innerHTML = "Eingaben sind gültig";
		msgbox.style.color = "green";
		speichern.removeAttribute('disabled');
	}
	else {
		msgbox.innerHTML = "Nicht alle Felder ausgefüllt !";
		msgbox.style.color = "red";
		speichern.setAttribute('disabled', 'disabled')
	}
}

//Waffen
let inputfilewaffen = document.getElementById('inputfilewaffen');
let bildvorschauwaffen = document.getElementById('BildvorschauWaffen');
let waffenname = document.getElementById('waffenname');
let waffenwert = document.getElementById('waffenwert');
let waffengeld = document.getElementById('waffengeld');
let waffenmsgbox = document.getElementById('waffenmessagebox');
let waffenspeichern = document.getElementById('waffenspeichern');
waffenname.addEventListener('input', ValidateDataWaffen)
waffenwert.addEventListener('input', ValidateDataWaffen)
waffengeld.addEventListener('input', ValidateDataWaffen)
inputfilewaffen.addEventListener('change', ValidateDataWaffen)
waffenloeschen.addEventListener('click', () => {
	inputfilewaffen.value = null;
	bildvorschauwaffen.src = "/Gegneravatare/Default.png";
	fileselectedwaffen = false;
	waffenspeichern.setAttribute('disabled', 'disabled');
	waffenmsgbox.style.color = "red";
	waffenmsgbox.innerHTML = "Kein Bild ausgewählt";
}
);

function PreviewImageWaffen() {
	var oFReader = new FileReader();
	oFReader.readAsDataURL(document.getElementById("inputfilewaffen").files[0]);
	oFReader.onload = function (oFREvent) {
		document.getElementById("BildvorschauWaffen").src = oFREvent.target.result;
	};
};

function ValidateDataWaffen() {
	if (waffenname.value != "" && waffenname.value.length > 0) { boolwaffenname = true; } else { boolwaffenname = false; }
	if (waffenwert.value != "" && waffenwert.value.length > 0) { boolwaffenwert = true; } else { boolwaffenwert = false; }
	if (waffengeld.value != "" && waffengeld.value.length > 0) { boolwaffengeld = true; } else { boolwaffengeld = false; }
	if (inputfilewaffen.files.length != 0) { fileselectedwaffen = true; } else { fileselectedwaffen = false; }

	if (boolwaffenname && boolwaffenwert && boolwaffengeld && fileselectedwaffen) {
		waffenmsgbox.innerHTML = "Eingaben sind gültig";
		waffenmsgbox.style.color = "green";
		waffenspeichern.removeAttribute('disabled');
	}
	else {
		waffenmsgbox.innerHTML = "Nicht alle Felder ausgefüllt !";
		waffenmsgbox.style.color = "red";
		waffenspeichern.setAttribute('disabled', 'disabled')
	}
}

//Rüstung
let inputfileruestung = document.getElementById('inputfileruestung');
let bildvorschauruestung = document.getElementById('BildvorschauRuestung');
let ruestungsname = document.getElementById('ruestungsname');
let ruestungswert = document.getElementById('ruestungswert');
let ruestungsgeld = document.getElementById('ruestungsgeld');
let ruestungsmsgbox = document.getElementById('ruestungsmessagebox');
let ruestungsspeichern = document.getElementById('ruestungsspeichern');
ruestungsname.addEventListener('input', ValidateDataRuestung)
ruestungswert.addEventListener('input', ValidateDataRuestung)
ruestungsgeld.addEventListener('input', ValidateDataRuestung)
inputfileruestung.addEventListener('change', ValidateDataRuestung)
ruestungloeschen.addEventListener('click', () => {
	inputfileruestung.value = null;
	bildvorschauruestung.src = "/Ruestungsbilder/Ruestung_Default.png";
	fileselectedruestung = false;
	ruestungspeichern.setAttribute('disabled', 'disabled');
	ruestungsmsgbox.style.color = "red";
	ruestungsmsgbox.innerHTML = "Kein Bild ausgewählt";
}
);

function PreviewImageRuestung() {
	var oFReader = new FileReader();
	oFReader.readAsDataURL(document.getElementById("inputfileruestung").files[0]);
	oFReader.onload = function (oFREvent) {
		document.getElementById("BildvorschauRuestung").src = oFREvent.target.result;
	};
};

function ValidateDataRuestung() {
	if (ruestungsname.value != "" && ruestungsname.value.length > 0) { boolruestungsname = true; } else { boolruestungsname = false; }
	if (ruestungswert.value != "" && ruestungswert.value.length > 0) { boolruestungswert = true; } else { boolruestungswert = false; }
	if (ruestungsgeld.value != "" && ruestungsgeld.value.length > 0) { boolruestungsgeld = true; } else { boolruestungsgeld = false; }
	if (inputfileruestung.files.length != 0) { fileselectedruestung = true; } else { fileselectedruestung = false; }

	if (boolruestungsname && boolruestungswert && boolruestungsgeld && fileselectedruestung) {
		ruestungsmsgbox.innerHTML = "Eingaben sind gültig";
		ruestungsmsgbox.style.color = "green";
		ruestungsspeichern.removeAttribute('disabled');
	}
	else {
		ruestungsmsgbox.innerHTML = "Nicht alle Felder ausgefüllt !";
		ruestungsmsgbox.style.color = "red";
		ruestungsspeichern.setAttribute('disabled', 'disabled')
	}
}

// Tränke
let inputfiletrank = document.getElementById('inputfiletrank');
let bildvorschautrank = document.getElementById('BildvorschauTrank');
let trankname = document.getElementById('trankname');
let trankwert = document.getElementById('trankwert');
let trankwertpermanent = document.getElementById('trankwertpermanent');
let trankwertverteidigung = document.getElementById('trankwertverteidigung');
let trankwertangriff = document.getElementById('trankwertangriff');
let trankgeld = document.getElementById('trankgeld');
let trankmsgbox = document.getElementById('trankmessagebox');
let trankspeichern = document.getElementById('trankspeichern');
trankname.addEventListener('input', ValidateDataTrank)
trankwert.addEventListener('input', ValidateDataTrank)
trankwertpermanent.addEventListener('input', ValidateDataTrank)
trankwertverteidigung.addEventListener('input', ValidateDataTrank)
trankwertangriff.addEventListener('input', ValidateDataTrank)
trankgeld.addEventListener('input', ValidateDataTrank)
inputfiletrank.addEventListener('change', ValidateDataTrank)
trankloeschen.addEventListener('click', () => {
	inputfiletrank.value = null;
	bildvorschautrank.src = "/Traenkebilder/Trank_Default.png";
	fileselectedtrank = false;
	trankspeichern.setAttribute('disabled', 'disabled');
	trankmsgbox.style.color = "red";
	trankmsgbox.innerHTML = "Kein Bild ausgewählt";
}
);

function PreviewImageTrank() {
	var oFReader = new FileReader();
	oFReader.readAsDataURL(document.getElementById("inputfiletrank").files[0]);
	oFReader.onload = function (oFREvent) {
		document.getElementById("BildvorschauTrank").src = oFREvent.target.result;
	};
};

function ValidateDataTrank() {
	if (trankname.value != "" && trankname.value.length > 0) { booltrankname = true; } else { booltrankname = false; }
	if (trankwert.value != "" && trankwert.value.length > 0) { booltrankwert = true; } else { booltrankwert = false; }
	if (trankwertpermanent.value != "" && trankwertpermanent.value.length > 0) { booltrankwertpermanent = true; } else { booltrankwertpermanent = false; }

	if (trankwertverteidigung.value != "" && trankwertverteidigung.value.length > 0) { booltrankwertverteidigung = true; } else { booltrankwertverteidigung = false; }

	if (trankwertangriff.value != "" && trankwertangriff.value.length > 0) { booltrankwertangriff = true; } else { booltrankwertangriff = false; }

	if (trankgeld.value != "" && trankgeld.value.length > 0) { booltrankgeld = true; } else { booltrankgeld = false; }
	if (inputfiletrank.files.length != 0) { fileselectedtrank = true; } else { fileselectedtrank = false; }

	if (booltrankname && booltrankwert && booltrankwertpermanent && booltrankwertverteidigung && booltrankwertangriff && booltrankgeld && fileselectedtrank) {
		trankmsgbox.innerHTML = "Eingaben sind gültig";
		trankmsgbox.style.color = "green";
		trankspeichern.removeAttribute('disabled');
	}
	else {
		trankmsgbox.innerHTML = "Nicht alle Felder ausgefüllt !";
		trankmsgbox.style.color = "red";
		trankspeichern.setAttribute('disabled', 'disabled')
	}
}
