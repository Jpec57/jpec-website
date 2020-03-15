import React from 'react';
import { useWindowSize } from '../../../hooks/useWindowSize';
import { Link } from 'react-router-dom';
import regression_lin_data from '../../../css/images/regression_lin_data.jpg';

const RegressionPage: React.FC = () => {
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
          <h3>Régression linéaire</h3>
          </div>

          <h3>Sommaire</h3>
      <h4>Introduction</h4>
      <ul>
        <li><a href="#use-anchor">Sources</a></li>
      </ul>
      <h4><a href='#sources-anchor'>Sources</a></h4>

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
        Régression linéaire
        </h1>
      </header>
      <h3>
          Introduction
        </h3>
        <p id="use-anchor">
            <i>"Une régression est un ensemble de méthodes statistiques très 
            utilisées pour analyser la relation d'une variable par rapport à un ou plusieurs autres" </i> 
            (<b>Source</b>: <a href="https://fr.wikipedia.org/wiki/R%C3%A9gression_(statistiques)">Wikipédia</a>).
<p>
Les problèmes de régression visent à résoudre des problèmes de prédiction d'une <b>variable quantitative</b> (comprendre variable à valeurs continues).
</p>
<p>
Plus précisément, nous décidons d'étudier un cas particulier des régressions: les <b>régressions linéaires</b>. La relation existante
            entre la variable étudiée et les autres se modélisera ainsi par une <b>droite</b>. 
</p>

        </p>

        <h3>
    Pourquoi une droite ?
</h3>
<p>
Parce que c'est moi qui décide :). Plus sérieusement, le choix de la droite pour modéliser notre problème est arbitraire. Toutefois, représenter les données sur un graphique
    quand cela est possible permet d'avoir souvent à première vue une intution du modèle qui conviendrait au problème. 
    <img src={regression_lin_data} alt="linear_regression_data"/>
    Ici, on peut voir intuitivement que la solution s'approche d'une droite. Cependant, nous aurions très bien pu approcher le problème à l'aide
    d'un polynome du second degré. 
</p>

<p>
    Finalement, en présence d'un graphique représentant l'observation en fonction de la variable, un problème de régression revient à trouver avec notre 
    règle <b>la</b> droite qui passe au plus proche d'un maximum de points.
</p>
<h3>
    Incidence de la contrainte
</h3>

<h3>
    Cas pratique
</h3>
<p>
    Nous allons ainsi nous intéresser à un cas simple ne comprenant qu'une seule variable à relier à une autre. 
</p>

<pre>
<code>
import numpy as np
</code>
<code>
import pandas as pd
</code>
<code>
import matplotlib.pyplot as plt

# On charge le dataset
house_data = pd.read_csv('house.csv')
house_data = house_data[house_data['loyer'] &lt; 10000]
# On affiche le nuage de points dont on dispose
plt.plot(house_data['surface'], house_data['loyer'], 'ro', markersize=4)

# On décompose le dataset et on le transforme en matrices pour pouvoir effectuer notre calcul avec les fameux 1 en premier
X = np.matrix([np.ones(house_data.shape[0]), house_data['surface'].values]).T
y = np.matrix(house_data['loyer']).T

# On effectue le calcul exact du paramètre theta
theta = np.linalg.inv(X.T.dot(X)).dot(X.T).dot(y)

print(theta)
# On affiche la droite entre 0 et 250 en donnant les points en 0 et 250 en deuxième argument
plt.plot([0,250], [theta.item(0),theta.item(0) + 250 * theta.item(1)], linestyle='--', c='#000000')
plt.show()
</code>
</pre>


        <h3>
          Sources
        </h3>
        <p>
            <ul>
                <li>
                <a href="https://openclassrooms.com/fr/courses/4011851-initiez-vous-au-machine-learning/4121986-programmez-votre-premiere-regression-lineaire">
                Open ClassRoom
            </a>
                </li>
            </ul>
            
        </p>

  </div>
      {renderRightMargin(size.width)}
      </div>
  );
}

export default RegressionPage;