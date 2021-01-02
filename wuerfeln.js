var x = 0;
var summep = 0;
var summenpc = 0;
var geld = 0;
document.getElementById("Guthaben").innerHTML = geld;
var einsatz = 0
var npcx = 1;
var objp = 0;
var objnpc = 0;
var idz = 0;
var wuerfel = [];

function npcsperren() {
  npcx = 0;
}

function buttonlock() {
  var disable = document.getElementById("Button");
  disable.setAttribute("onclick", "")
}

function buttonunlock() {
  if (summenpc <= 17 && summep <= 17) {
    var enable = document.getElementById("Button");
    enable.setAttribute("onclick", "roll()")
  }
}

function nbuttonlock() {
  var ndisable = document.getElementById("NButton");
  ndisable.setAttribute("onclick", "")
}

function nbuttonunlock() {
  var nenable = document.getElementById("NButton");
  nenable.setAttribute("onclick", "winner()")
}

function submitbuttonlock() {
  var disable = document.getElementById("setzen");
  disable.setAttribute("onclick", "")
}

function submitbuttonunlock() {
  var enable = document.getElementById("setzen");
  enable.setAttribute("onclick", "Setzen()")
}

function roll() {
  WuerfelSound();
  p();
  setTimeout(npc, 2000);
  setTimeout(proof, 2050);
  setTimeout(fall, 2050);
  nbuttonunlock();
  setTimeout(buttonunlock, 2050);
}

function winner() {
  stop();
  fall();
  buttonlock();
  nbuttonlock();
}

function p() {
  var number = Math.floor(Math.random() * 6) + 1;
  var elem = document.createElement("img");
  elem.setAttribute("src", "Bilder/" + number + ".png");
  elem.setAttribute("id", "deletep");
  document.getElementById("p").appendChild(elem);
  summep = summep + number;

  objp++;
  buttonlock();
  submitbuttonlock();
}

function npc() {
  WuerfelSoundGegner();
  if (npcx == 1) {
    var number = Math.floor(Math.random() * 6) + 1;
    wuerfel.push(number);

    id();
    summenpc = summenpc + number;
    if (summenpc > 14) {
      npcsperren();
    }
    buttonlock();
    submitbuttonlock();
    objnpc++;
  }
}

function proof() {
  if (summep > 17) {
    var disable = document.getElementById("Button");
    disable.setAttribute("onclick", "");
    x = 2;
  }
  if (summenpc > 17) {
    var disable = document.getElementById("Button");
    disable.setAttribute("onclick", "");
    x = 1;
  }
  if (summep == summenpc && summep > 17 && summenpc > 17) { x = 3; }

}

function stop() {
  if (summenpc <= 14) {
    while (summenpc <= 14) {
      npc();
    }
    if (summep > 17) { x = 2; }
    if (summep <= 17 && summep > summenpc) { x = 1; }
    if (summenpc > 17) { x = 1; }
    if (summenpc <= 17 && summenpc > summep) { x = 2; }
    if (summep == summenpc) { x = 3; }
    fall();
  }
  else {
    if (summep <= 17 && summep > summenpc) { x = 1; }
    if (summenpc <= 17 && summenpc > summep) { x = 2; }
    if (summep == summenpc) { x = 3; }
    fall();
  }
}

function fall() {
  switch (x) {
    case 1: document.getElementById("Meldung").innerHTML = "!!! Du hast Gewonnen !!!";
      buttonlock();
      nbuttonlock();
      npcsperren();
      show();
      console.log("gewonnen");
      ErgebnissSenden("gewonnen");

      break;

    case 2: document.getElementById("Meldung").innerHTML = "!!! Du hast Verloren !!!";
      buttonlock();
      nbuttonlock();
      show();
      npcsperren();
      console.log("verloren");
      ErgebnissSenden("verloren");
      break;

    case 3: document.getElementById("Meldung").innerHTML = "!!! Unentschieden !!!";
      buttonlock();
      nbuttonlock();
      show();
      npcsperren();
      ErgebnissSenden("unentschieden");

      break;

    default:
      break;
  }
}

function Setzen() {
  KaufSound();
  EinsatzSenden();
  einsatz = parseInt(document.getElementById("Text").value);

  if (einsatz <= geld) {
    document.getElementById("Einsatzwert").innerHTML = einsatz;

    geld = geld - einsatz;
    document.getElementById("Guthaben").innerHTML = geld;

    submitbuttonlock();
    buttonunlock();
    document.getElementById("Meldung").innerHTML = "!!! Gesetzt !!!";

    return geld;
  }
  else {
    if (geld == 0) {
      document.getElementById("Meldung").innerHTML = "!!! Du bist Pleite !!!";
    }
    else {
      document.getElementById("Meldung").innerHTML = "Maximal " + geld + " setzbar";
    }
  }
}

function npcScore(summenpc) {
  document.getElementById("npcScore").innerHTML = summenpc;
}

function reset() {

  window.location.href = 'taverne.php';

  /*
  Geldabholen();
  NeuesSpielSound();
  buttonunlock();
  summep = 0;
  summenpc = 0;
  einsatz = 0;
  npcx = 1;
  idz = 0;
  wuerfel = [];
  wuerfel.length = 0;

  document.getElementById("Einsatzwert").innerHTML = einsatz;
  document.getElementById("Meldung").innerHTML = "Neues Spiel";

  while (objp > 0) {
    var elemp = document.getElementById("deletep");
    elemp.remove();
    objp--;
    summep = 0;
  }

  deletenpc();
  submitbuttonunlock();

  x = 0; */

}

function id() {
  var elem2 = document.createElement("img");
  elem2.setAttribute("src", "Bilder/F.png");
  idz++;

  elem2.setAttribute("id", "deletenpc" + (idz - 1));
  document.getElementById("npc").appendChild(elem2);
}


function show() {

  for (let i = 0; i < wuerfel.length; i++) {
    var show = wuerfel[i];
    var deck = document.getElementById("deletenpc" + i);
    show == deck
    deck.setAttribute("src", "Bilder/" + show + ".png");
  }
}

function deletenpc() {
  while (objnpc > 0) {
    if (objnpc == 1) {
      var elemnpc = document.getElementById("deletenpc0");
      elemnpc.remove();
      objnpc--;
    }
    if (objnpc == 2) {
      var elemnpc = document.getElementById("deletenpc1");
      elemnpc.remove();
      objnpc--;
    }
    if (objnpc == 3) {
      var elemnpc = document.getElementById("deletenpc2");
      elemnpc.remove();
      objnpc--;
    }
    if (objnpc == 4) {
      var elemnpc = document.getElementById("deletenpc3");
      elemnpc.remove();
      objnpc--;
    }
    if (objnpc == 5) {
      var elemnpc = document.getElementById("deletenpc4");
      elemnpc.remove();
      objnpc--;
    }
    if (objnpc == 6) {
      var elemnpc = document.getElementById("deletenpc5");
      elemnpc.remove();
      objnpc--;
    }
    if (objnpc == 7) {
      var elemnpc = document.getElementById("deletenpc6");
      elemnpc.remove();
      objnpc--;
    }
    if (objnpc == 8) {
      var elemnpc = document.getElementById("deletenpc7");
      elemnpc.remove();
      objnpc--;
    }
    if (objnpc == 9) {
      var elemnpc = document.getElementById("deletenpc8");
      elemnpc.remove();
      objnpc--;
    }
    if (objnpc == 10) {
      var elemnpc = document.getElementById("deletenpc9");
      elemnpc.remove();
      objnpc--;
    }
  }
  summenpc = 0;
}

function WuerfelSound() {
  var audio = new Audio('/Audio/würfeln2.wav');
  audio.play();
}
function WuerfelSoundGegner() {
  var audio = new Audio('/Audio/würfeln.wav');
  audio.play();
}
function KaufSound() {
  var audio = new Audio('/Audio/coin.wav');
  audio.play();
}
function NeuesSpielSound() {
  var audio = new Audio('/Audio/tap.wav');
  audio.play();
}

function Geldabholen() {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      geld = this.responseText;
      document.getElementById("Guthaben").innerHTML = geld;
    }
  };
  xmlhttp.open("POST", "funktionen.php", true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send("action=spielergeldabfragen");
}

function ErgebnissSenden(ergebnis) {

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      geld = this.responseText;
      document.getElementById("Guthaben").innerHTML = geld;
    }
  };
  xmlhttp.open("POST", "funktionen.php", true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send("action=spielergebniswuerfeln&ergebnis=" + ergebnis + "");

}

function EinsatzSenden() {
  var einsatzwert = 0;
  einsatzwert = document.getElementById("Text").value;

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.open("POST", "funktionen.php", true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send("action=spielereinsatz&einsatz=" + einsatzwert + "");
}




