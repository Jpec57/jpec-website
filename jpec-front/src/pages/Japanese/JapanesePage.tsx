import React, {useRef, MutableRefObject, useState, useEffect} from 'react';
import './JapanesePage.scss';
import '../../japanese-translations/test_jap.srt';
const text = `
1
00:00:02,168 --> 00:00:04,170
（ナレーション）
富 名声 力

2
00:00:04,295 --> 00:00:08,383
この世のすべてを手に入れた男
海賊王 ゴールド･ロジャー

3
00:00:08,508 --> 00:00:12,137
彼の死に際に放ったひと言は
人々を海へ駆り立てた

4
00:00:12,303 --> 00:00:15,932
（ゴールド･ロジャー）
俺の財宝か？
欲しけりゃくれてやる

5
00:00:16,099 --> 00:00:19,644
探せ！ この世のすべてを
そこに置いてきた

6
00:00:22,272 --> 00:00:24,774
（ナレーション）
男たちは
グランドラインを目指し

7
00:00:24,899 --> 00:00:26,651
夢を追い続ける

8
00:00:27,027 --> 00:00:30,280
世は まさに大海賊時代！

9
00:00:30,989 --> 00:00:36,995
♪～

10
00:01:43,978 --> 00:01:50,485
～♪

11
00:01:50,902 --> 00:01:57,909
`;
type SpeechConfig = {
  pitch: number, //between 0 and 2
  rate: number, // between 0 and 1
  text: string,
  voice: SpeechSynthesisVoice | null,
  volume: number, // between 0 and 1
}

//https://www3.nhk.or.jp/news/easy/
const JapanesePage: React.FC = () => {
  const dialogueLines: Array<String> = [];
  const [isPlaying, setIsPlaying] = useState(false);

  fetch('https://jpec-website.herokuapp.com').then((response)=>{
    return response.json();
  }).then((data)=>{
    console.log(data);
  });


  fetch('http://127.0.0.1:8000/test').then((response)=>{
    return response.json();
  }).then((data)=>{
    console.log(data);
  });

  const splitSrtFile = () =>{
    const frames = text.trim().split("\n\n");
    frames.forEach((frame)=>{
      const lines = frame.split("\n");
      dialogueLines.push(lines.slice(2).join("\n"));
    });
    // console.log(dialogueLines.join("\n\n"));
  };

  splitSrtFile();

  if ('speechSynthesis' in window) {
    console.log('Ok');
  } else {
    console.log('Not supported.');
  }
    var speechSynthesisVar: MutableRefObject<SpeechSynthesisUtterance | null> = useRef(null);


    const configureSpeechSynthesis = (rate: number = 1): SpeechSynthesisUtterance => {
        const msg = new SpeechSynthesisUtterance();
        msg.voice = window.speechSynthesis.getVoices()
            .filter((voice) => 
                voice.name === 'Kyoko'
                )[0];
        msg.rate = rate;
        msg.pitch = 0.3;
        return msg;
    };

    //TODO should only look once at page load but doesn't work
    useEffect(()=>{
        speechSynthesisVar.current = configureSpeechSynthesis();
    }, []);

    const say = (message: string, rate: number = 1) => {
        speechSynthesisVar.current = configureSpeechSynthesis(rate);
        speechSynthesisVar.current.text = message;
        window.speechSynthesis.speak(speechSynthesisVar.current);
        // window.s
    };

  return (
    <div className="container">
      <header className="header-content">
      </header>
      <div>
        <span>This is a test</span>
        <div className="audio-player">
        <div className="audio-controller-box">
<div className="audio-rate">

</div>
<div className="centered-div">
<i className="icon solid fa-play-circle" onClick={()=>{
            say('234')
            }}/>
  </div>
        </div>
        <div className="answer-box">

<input />
        </div>
        <div className="correction-box">

        </div>
        </div>


<div style={{marginTop: 40}}>
{dialogueLines.map((line, index)=>{
  return (<p key={index}>{line.trim()}</p>);
})}
</div>

        <button onClick={()=>{
            say(dialogueLines.join("\n"), 0.9)
            }}>
            Click here
        </button>



      </div>
    </div>
  );
}

export default JapanesePage;
