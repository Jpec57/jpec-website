import React, {useRef, MutableRefObject, useState, useEffect} from 'react';
import './JapanesePage.scss';

//https://www3.nhk.or.jp/news/easy/
const JapanesePage: React.FC = () => {
  const [isPlaying, setIsPlaying] = useState(false);

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
        return msg;
    };

    //TODO should only look once at page load but doesn't work
    useEffect(()=>{
        speechSynthesisVar.current = configureSpeechSynthesis();
    }, []);

    const say = (message: string) => {
        speechSynthesisVar.current = configureSpeechSynthesis();
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
        <button onClick={()=>{
            say('234 国内外の取材網を生かし、さまざまな分野のニュースをいち早く、正確にお伝えします')
            }}>
            Click here
        </button>
      </div>
    </div>
  );
}

export default JapanesePage;
