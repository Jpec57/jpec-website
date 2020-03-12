import React from 'react';
import { useWindowSize } from '../../../hooks/useWindowSize';
import { Link } from 'react-router-dom';
const Latex = require('react-latex');

const DeepLearningPage: React.FC = () => {
  const size = useWindowSize();
  
  const renderTableContent = (width: number | undefined) => {
    if (typeof width === "undefined" || (width != null && width < 650)){
      return (
        <div className="flex-1">
        </div>
      );
    }
      return (
        <div className="table-content">
        <div className="table-content-enum">
          <div className="flex-horizontal">
          <Link to="/math" className="icon solid fa-chevron-left mr-15"></Link>
          <h3>Apprentissage profond</h3>
          </div>

          <h3>Sommaire</h3>
      <h4>Introduction</h4>
      <ul>
        <li><a href="#definition-anchor">Definitions</a></li>
        <li><a href="#knowledge-based-anchor">Approche fondée sur la connaissance</a></li>
        <li><a href="#automatic-learning-anchor">Apprentissage automatique</a></li>
        <li><a href="#representation-learning-anchor">Apprentissage de représentation</a></li>
        <li><a href="#deep-learning-anchor">Apprentissage profond</a></li>
      </ul>
        </div>
  </div>
      );
  };

  const renderRightMargin = (width: number | undefined) => {
    if (typeof width === "undefined" || (width != null && width < 650)){
      return (
        <div className="flex-1"></div>
      );
    }
    return (
      <div className="flex-2"></div>
    );
  }

  return (

    <div className="container flex-horizontal">

    {renderTableContent(size.width)}


  <div className="main">
  <header className="content-header">
        <h1>
          Apprentissage profond
        </h1>
      </header>
      <h3>
          Introduction
        </h3>
        <p className="definition-anchor">

          L'apprentissage profond, autrement appelé <i>Deep learning</i> est un ensemble de méthodes d'apprentissage automatique tentant de tirer
          des informations à partir de données brutes pour les modéliser. 
        
        <br></br>
        Cette modélisation est construite à l'aide d'un enchaînement d'opérations mathématiques
          que l'on compare fréquemment au fonctionnement du cerveau humain avec les neurones. 
          Pour cette raison, l'apprentisage profond est très souvent appelé "réseau de neurones artificiels"
          (RNA). Cette similitude est due à l'inspiration qu'à évoquer l'étude du cerveau humain 
          pour établir un algorithme de pensée efficace pour l'ordinateur. Toutefois, la similitude s'arrête ici
          car l'apprentissage profond n'a pas pour but de copier le fonctionnement exact du cerveau humain, ni
          d'en comprendre tous les rouages, mais bien simplement de s'en inspirer.

        </p>
        <p id='knowledge-based-anchor'>
          Durant les premiers balbutiements de l'IA, on chercha à codifier les connaissances du monde en un langage 
          formel sur lequel l'ordinateur pouvait raisonner en utilisant des règles d'inférences logiques: c'est <b>l'approche
          fondée sur la connaissance.</b>
        <p>

        </p>
          Toutefois, les difficultés de mémoire et de complexité d'encodage amenèrent rapidement les programmes à tenter d'exploiter 
          directement les données brutes pour en extraire eux même des modèles.
        </p>
        <p id='automatic-learning-anchor'>
          <b>L'apprentissage automatique</b> permet de s'affranchir de l'énumération de tous les comportements possibles
          en se basant sur une représentation des données qui leur est transmise. 
          La performance de ces algorithmes dépendaient beaucoup de la représentation des données transmises. On
          communique à l'ordinateur les points clés à prendre en compte pour une décision. 
        </p>
        <p id='automatic-learning-limit-anchor'>
          Très perfomant pour bon nombre
          de tâches, il n'en reste pas moins impossible à appliquer à divers problématiques telles que la reconnaissance
          d'une roue sur une image. En effet, notre expérience en tant qu'être vivant nous a permis, au travers de milliers
          d'exemples observés de définir ce qu'est une roue, mais comment cela se traduit il en pixels ? La définir comme un cercle
          reviendrait à oublier les ombres pouvant perturber l'image, les objets pouvant cacher la vue totale de la roue...

        </p>
        <p id='representation-learning-anchor'>
          <b>L'apprentisage de représentation</b> permet de découvrir les caractéristiques composant la donnée. Le but 
          de ce type d'algorithme est généralement de différencier les facteurs de variation (sources d'influence de la donnée)
          
        </p>
        <p id='representation-learning-limitation-anchor'>
          Lorsqu'il est presque aussi difficile d'obtenir une représentation que de résoudre le problème initial,
          l'apprentisage par représentation ne semble pas suffire.

          Par exemple, si ces données sont trop sophistiquées et nécessitent une expérience digne d'un
          humain afin d'en apercevoir les nuances comme pourrait l'être la distinction de l'accent d'une personne
          l'apprentissage profond est nécessaire.
          </p>
        <p id="deep-learning-anchor">
          <b>L'apprentissage profond</b> permet quant à lui de déduire des représentations complexes à partir de
          représentations simples et intermédiaires. A partir des différences de pixels, 
          le programme peut distinguer les coins et les contours présents sur l'image pour déterminer 
          les bords de l'objet représenté. On se dirige des couches visibles vers des couches "cachées"
          représentant des concepts abstraits.
        </p>

        <Latex>What is $(3\times 4) \div (5-3)$</Latex>
  </div>
      {renderRightMargin(size.width)}
      </div>
  );
}

export default DeepLearningPage;
/*
Récupérer les données
Nettoyer (consistantes et sans valeur abbérante)
Explorer 
Créer le modèle statistique
Evaluer la qualité du modèle (à représenter)
Déployer l'algorithme (en production)


chaque donnée observée est l'expression d'une variable aléatoire générée par une distribution de probabilité
*/