//X
function KampfStarten(Spieler, Gegner) {
  var audio = new Audio('/Audio/tap.wav');
  audio.play();
  SpielerSperren();
  let kampfstartenbutton = document.getElementById("kampfstartenbutton");
  kampfstartenbutton.style.display = "none";
  let Kampfbeginner = Beginner(Spieler, Gegner);
  let Kampfnichtbeginner = null;
  if (Kampfbeginner === Spieler) { Kampfnichtbeginner = Gegner }
  else { Kampfnichtbeginner = Spieler; }

  KampfRunde(Kampfbeginner, Kampfnichtbeginner);
}
//X
function KampfRunde(Kampfbeginner, Kampfnichtbeginner) {
  (async function () {
    async function sleep(ms) {
      return new Promise((resolve) => setTimeout(resolve, ms));
    }

    if (Kampfnichtbeginner.leben > 0 && Kampfbeginner.leben > 0) {
      await sleep(1000);
      SkalierenGroß(AngriffsID(Kampfbeginner));
      await sleep(1000);
      AngriffSound();
      SkalierenKlein(AngriffsID(Kampfbeginner));
      SkalierenGroß(LebenID(Kampfnichtbeginner));
      await sleep(1000);
      SkalierenKlein(LebenID(Kampfnichtbeginner));
      SchadenSound(Kampfnichtbeginner);
      Kampfbeginner.Angreifen(Kampfnichtbeginner);//Angriff
      await sleep(100);
    }

    if (Kampfbeginner.leben > 0 && Kampfnichtbeginner.leben > 0) {
      await sleep(1000);
      SkalierenGroß(AngriffsID(Kampfnichtbeginner));
      await sleep(1000);
      AngriffSound();
      SkalierenKlein(AngriffsID(Kampfnichtbeginner));
      SkalierenGroß(LebenID(Kampfbeginner));
      await sleep(1000);
      SkalierenKlein(LebenID(Kampfbeginner));
      SchadenSound(Kampfbeginner);
      Kampfnichtbeginner.Angreifen(Kampfbeginner); //Angriff
      await sleep(100);
    }

    if (Kampfbeginner.leben > 0 && Kampfnichtbeginner.leben > 0) {
      KampfRunde(Kampfbeginner, Kampfnichtbeginner);
    }
  }
  )()
}
//X
function Kampfende(Angreifer, Gegner) {
  if (Angreifer.seite === "links") {
    SpielerLinks = Angreifer;
    GegnerRechts = Gegner;
  }
  else { SpielerLinks = Gegner; GegnerRechts = Angreifer; }

  Gewinner = null;
  Verlierer = null;
  verdienst = null;
  erfahrung = null;
  verlust = null;
  lvlupbool = false;
  gewinngergeldvorher = false;
  verlierergeldvorher = false;
  if (SpielerLinks.leben > 0 && GegnerRechts.leben <= 0) {
    Gewinner = SpielerLinks;
    Verlierer = GegnerRechts;
    gewinnergeldvorher = SpielerLinks.geld;
    verlierergeldvorher = GegnerRechts.geld;
    Gewinner.geld += Verlierer.geld;
    erfahrungvorher = Gewinner.erfahrung;
    Gewinner.erfahrung += GegnerRechts.erfahrung;
    if (Gewinner.erfahrung > Gewinner.lvl * 100) {
      Gewinner.erfahrung = erfahrungvorher + GegnerRechts.erfahrung - (Gewinner.lvl * 100);
      Gewinner.lvl++;
      Gewinner.maxleben += 3;
      Gewinner.angriffswert += 1;
      lvlupbool = true;
    }
    verdienst = Verlierer.geld;
    verlust = Verlierer.geld;
    erfahrung = Verlierer.erfahrung;
    Verlierer.geld = 0;
  }
  else {
    Gewinner = GegnerRechts;
    Verlierer = SpielerLinks;
    gewinnergeldvorher = GegnerRechts.geld;
    verlierergeldvorher = SpielerLinks.geld;
    differenz = 0;

    if (Verlierer.geld > 0 && Gewinner.geld > Verlierer.geld) {

      if (Verlierer.geld === 1) {
        differenz = 1;
      }
      else { differenz = Math.round(Verlierer.geld / 2); }

      verdienst = differenz;
      Gewinner.geld += differenz;
      verlust = differenz;
      Verlierer.geld -= verlust;
    }
    else {
      verlust = Gewinner.geld;
      Verlierer.geld -= verlust;
      verdienst = Gewinner.geld * 2;
      Gewinner.geld += verdienst;
    }

    erfahrung = 0;
  }

  PopUp();

  let kampfergebnisse = document.getElementById("Kampfergebnisse");
  let kampfgewinner = document.getElementById("kampfgewinner");
  let kampfgeld = document.getElementById("kampfgeld");
  let kampferfahrung = document.getElementById("kampferfahrung");
  let kampfverlierer = document.getElementById("kampfgeldverlust");


  kampfergebnisse.style.display = "block";
  kampfgewinner.innerHTML = `${Gewinner.name} hat gegen ${Verlierer.name} gewonnen !`;
  if (Gewinner.seite === "rechts") {
    kampfgeld.innerHTML = "";
    kampferfahrung.innerHTML = "";
    kampfgewinner.style.color = "#ff0000";
    setTimeout(function () { var audio = new Audio('/Audio/fail.wav'); audio.play(); }, 1000);
  }
  else {
    kampfgeld.innerHTML = `${Gewinner.name} bekommt ${verdienst} Geld !`;
    kampferfahrung.innerHTML = `${Gewinner.name} bekommt ${erfahrung} Erfahrung !`;
    kampfgewinner.style.color = "#006600";
    setTimeout(function () { var audio = new Audio('/Audio/fanfare.wav'); audio.play(); }, 1000);
  }
  if (Verlierer.seite === "links")
    kampfverlierer.innerHTML = `${Verlierer.name} verliert ${verlust} Geld !`;
  else { kampfverlierer.innerHTML = ""; }

  KampfergebnisseLoggen(Gewinner.name, Verlierer.name, verdienst, verlust, erfahrung);
  if (lvlupbool === true) {
    let lvlup = document.getElementById("lvlup");
    lvlup.innerHTML = `${Gewinner.name} ist jetzt Level ${Gewinner.lvl}!`;
    KampfergebnisseLoggenLvLUp(Gewinner.name, Gewinner.lvl);
  }
  // Zurück in die Datenbank
  VersendenVorbereiten(SpielerLinks, GegnerRechts);
}
//X
class Avatar {
  constructor(name, lvl, angriff, ruestungswert, leben, uiruestung, uileben, seite, geld, erfahrung, angriffswert, maxleben) {
    this.name = name;
    this.lvl = lvl;
    this.angriff = angriff;
    this.ruestungswert = ruestungswert;
    this.leben = leben;
    this.uiruestung = uiruestung;
    this.uileben = uileben;
    this.seite = seite;
    this.geld = geld;
    this.erfahrung = erfahrung;
    this.angriffswert = angriffswert;
    this.maxleben = maxleben;
  }
  Angreifen(Gegner) {
    if (this.leben > 0 && Gegner.leben > 0) {
      if (this.angriff > Gegner.ruestungswert) {
        Gegner.leben = (Gegner.leben + Gegner.ruestungswert) - this.angriff;
        Gegner.ruestungswert = 0;
      }
      else if (Gegner.ruestungswert > 0) { Gegner.ruestungswert = Gegner.ruestungswert - this.angriff; }
      if (Gegner.leben < 0)
        Gegner.leben = 0;
      Gegner.uiruestung.innerText = Gegner.ruestungswert;
      Gegner.uileben.innerText = Gegner.leben;

      if (Gegner.leben <= 0)
        Kampfende(this, Gegner);
    }

  }
}

function GegnerErfahrungBerechnen(lvl, leben, angriff) {
  value = lvl + leben + angriff;
  erfahrung = Math.round(value);
  return erfahrung;
}
//X
function SpielerErfahrungBerechnen(lvl, maxleben, angriff, ruestung) {
  value = lvl * 10 + maxleben + angriff, ruestung;
  erfahrung = Math.round(value);
  return erfahrung;
}
//X
function AngriffsID(Avatar) {
  if (Avatar.seite === "links") { return "AngriffRahmenLinks"; }
  else { return "AngriffRahmenGegnerLinks"; }
}

function AngriffSound() {
  var audio = new Audio('/Audio/schwertschwung.wav');
  audio.play();
}
function SchadenSound(Avatar) {
  if (Avatar.ruestungswert === 0) {
    var audio = new Audio('/Audio/menschschmerz.wav');
    audio.play();
  }
  else {
    var audio = new Audio('/Audio/schwerttreffer.wav');
    audio.play();
  }
}
//X
function LebenID(Avatar) {
  if (Avatar.seite === "links") {
    if (Avatar.ruestungswert === 0)
      return "LebenRahmenMitte"
    else { return "RuestungRahmenLinks"; }
  }
  else { return "LebenRahmenRechts"; }
}
//X
function Beginner(Spieler, Gegner) {
  let value = Math.floor(Math.random() * Math.floor(2));
  if (value === 1) { return Spieler; }
  else { return Gegner };
}


function SkalierenGroß(id) {
  let element = document.getElementById(id)
  let test = document.getElementById("test");

  element.style.transform = "translate(+0%, +0%) scale(1.05)";
  element.style.backgroundColor = "red";
}
function SkalierenKlein(id) {
  let element = document.getElementById(id);
  let test = document.getElementById("test");

  element.style.transform = "translate(+0%, +0%) scale(1.0)";
  element.style.backgroundColor = "transparent";
  if (element.id === "LebenRahmenMitte")
    element.style.backgroundColor = "grey";
}

function PopUp() {
  let popup
  popup = document.querySelector("#Kampfergebnisse")
  if (popup !== null) {
    popup.style.opacity = 1;
    popup.style.transform = "translate(+0%, +0%) scale(1)";
  }
}
