let open = document.querySelector(".open");
let surahs = document.querySelector(".surahs");
let close = document.querySelector(".close");
let sous = document.querySelector(".sous");
let input2 = document.querySelector(".searchA");
let input = document.querySelector(".searchE");
let button = document.querySelector(".button");
let popup = document.querySelector(".popup");
const audioPlayer = new Audio();

function playAudio(src) {
    audioPlayer.src = src;
    audioPlayer.play();
}

open.addEventListener("click", () => {
    sous.style.transform = "translateX(-100%)";
});

close.addEventListener("click", () => {
    sous.style.transform = "translateX(0%)";
});

getSurahs();

async function getSurahs() {
    try {
        const [metaResponse, suwarResponse, quranResponse] = await Promise.all([
            fetch("https://api.alquran.cloud/v1/meta"),
            fetch("https://www.mp3quran.net/api/v3/suwar?language=ar"),
            fetch("https://api.alquran.cloud/v1/quran/en.asad")
        ]);
        
        if (!metaResponse.ok || !suwarResponse.ok || !quranResponse.ok) {
            throw new Error('Failed to fetch data');
        }
        
        const [metaData, suwarData, quranData] = await Promise.all([
            metaResponse.json(),
            suwarResponse.json(),
            quranResponse.json()
        ]);

        let hh = metaData.data.surahs.references;
        let hhh = suwarData.suwar;
        let hhhh = quranData.data.surahs;

        let surahsHTML = "";
        for (let i = 0; i < 114; i++) {
            let nameE = hh[i].englishName;
            let nameEE = nameE.split("-");
            let nameEEE = nameEE.join(" ");
            surahsHTML += `
                <div class="one" data-nameA="${hhh[i].name}" data-nameE="${nameEEE}" data-nbr="${hhh[i].id}">
                    <div class="number">
                        <h5>${hh[i].number}</h5>
                    </div>
                    <div class="name">
                        <h4 class="simple">${hh[i].name}</h4>
                        <h5 class="trans">${hh[i].englishName}</h5>
                    </div>
                    <h5 class="numbers">${hh[i].numberOfAyahs} Ayahs</h5>
                </div>
            `;
        }
        surahs.innerHTML = surahsHTML;
        document.querySelector('.spinner').style.display = 'none';
        let ones = document.querySelectorAll(".one");

        input.addEventListener("keyup", (y) => {
            let value = y.target.value.toLowerCase();
            ones.forEach((t) => {
                let yyyy = t.getAttribute("data-namee").toLowerCase();
                t.style.display = yyyy.includes(value) ? "flex" : "none";
            });
        });

        input2.addEventListener("keyup", (y) => {
            let value = y.target.value.toLowerCase();
            ones.forEach((t) => {
                let yyyy = t.getAttribute("data-name").toLowerCase();
                t.style.display = yyyy.includes(value) ? "flex" : "none";
            });
        });

        ones.forEach((u) => {
            u.addEventListener("click", async () => {
                document.querySelector('.spinner').style.display = 'block';
                popup.style.display = "none";
                let nameSurah = u.getAttribute("data-nbr");
                let response = await fetch(`https://api.alquran.cloud/v1/surah/${nameSurah}/ar.alafasy`);
                let data3 = await response.json();
                let hhhhh = data3.data.ayahs;
                let hhhhSurah = hhhh[nameSurah - 1].ayahs;

                let popupHTML = `
                    <i class="fa-solid fa-xmark cancel"></i>
                    <div class="fo9">
                        <h4 class="ism">${hhh[nameSurah - 1].name}</h4>
                        <audio class="audioSurah" data-surah="${nameSurah}" src="https://cdn.islamic.network/quran/audio-surah/128/ar.alafasy/${nameSurah}.mp3"></audio>
                    </div>
                    <div class="middle">
                        <h4 data-surah="${nameSurah}" class="playSurah"><i  class="fa-solid fa-play"></i> Play Surah</h4>
                        <h4 data-surah="${nameSurah}" class="pauseSurah" style="display: none;"><i  class="fa-solid fa-pause"></i> Pause Surah</h4>
                    </div>
                    <div class="taht"></div>
                `;

                for (let y = 0; y < hh[nameSurah - 1].numberOfAyahs; y++) {
                    popupHTML += `
                        <div class="wahda">
                            <div class="buttons">
                                <i data-ayah="${y + 1}" class="fa-solid fa-play play"></i>
                                <i data-ayah="${y + 1}" class="fa-solid fa-stop stop"></i>
                            </div>
                            <div class="arabe">
                                <p>${hhhhh[y].text} ${y + 1}</p>
                            </div>
                            <div class="english">
                                <p>${hhhhSurah[y].text}</p>
                            </div>
                            <h3 style="display:none" class="audio" data-ayah="${y + 1}" data-src="${hhhhh[y].audio}"></h3>
                        </div>
                    `;
                }
                popup.innerHTML = popupHTML;
                document.querySelector('.spinner').style.display = 'none';
                popup.style.display = "flex";

                let audios = document.querySelectorAll(".audio");
                let play = document.querySelectorAll(".play");
                let stop = document.querySelectorAll(".stop");

                play.forEach((e) => {
                    e.addEventListener("click", () => {
                        let ida = e.getAttribute("data-ayah");
                        audios.forEach((t) => {
                            let idada = t.getAttribute("data-ayah");
                            if (ida === idada) {
                                playAudio(t.getAttribute("data-src"));
                            }
                        });
                    });
                });
                stop.forEach((e) => {
                    e.addEventListener("click", () => {
                        audioPlayer.pause();
                    });
                });

                let cancel = document.querySelector(".cancel");
                cancel.addEventListener("click", () => {
                    popup.style.display = "none";
                    popup.innerHTML = "";
                });

                let playSurahs = document.querySelector(".playSurah");
                let pauseSurah = document.querySelector(".pauseSurah");
                let audioSurah = document.querySelector(".audioSurah");

                playSurahs.addEventListener("click", () => {
                    audioSurah.play();
                    playSurahs.style.display = "none";
                    pauseSurah.style.display = "block";
                });
                pauseSurah.addEventListener("click", () => {
                    audioSurah.pause();
                    playSurahs.style.display = "block";
                    pauseSurah.style.display = "none";
                });
            });
        });
     } catch (error) {
        console.error('Error fetching data:', error);
    }
}

let k = 0;

button.addEventListener("click", () => {
    getSurahs();
    if (k == 0) {
        input.style.display = "none";
        input2.style.display = "flex";
        button.innerHTML = "Click to change the search to English";
        input.value = "";
        input2.value = "";
        k = 1;
    } else {
        input.style.display = "flex";
        input2.style.display = "none";
        button.innerHTML = "اضغط لتغيير البحث لللغة العربية";
        k = 0;
        input.value = "";
        input2.value = "";
    }
});
