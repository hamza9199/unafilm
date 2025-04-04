import './App.css'
import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Home from './stranice/Home';
import FilmInfo from './stranice/FilmInfo';
import Onama from './stranice/Onama';
import Kontakt from './stranice/Kontakt';
import TrenutnoUKinima from './stranice/TrenutnoUKinima';
import Header from './komponente/Header';
import Footer from './komponente/Footer';
import UskoroUKinima from './stranice/UskoroUKinima';
import Arhiva from './stranice/Arhiva';
import IzSvijetaFilma from './stranice/IzSvijetaFilma';
import TrejleriNovosti from './stranice/TrejleriNovosti';
import Novosti from './stranice/Novosti';
import FilmTrejler from './stranice/FilmTrejler';
import FilmOpis from './stranice/FilmOpis';
import Search from './stranice/Search';



function App() {

  return (
    <Router>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/o-nama" element={<Onama />} />
        <Route path="/novosti/film/:id" element={<FilmInfo />} />
        <Route path="/novosti/iz-svijeta-filma/film/:id" element={<FilmInfo />} />
        <Route path="/novosti/traileri/film/:id" element={<FilmTrejler />} />
        <Route path="/trenutno-u-kinima/film/:id" element={<FilmOpis/>} />
        <Route path="/uskoro-u-kinima/film/:id" element={<FilmOpis/>} />
        <Route path="/arhiva/film/:id" element={<FilmOpis />} />
        <Route path="/kontakt" element={<Kontakt/>} />
        <Route path="/trenutno-u-kinima" element={<TrenutnoUKinima/>} />
        <Route path="/uskoro-u-kinima" element={<UskoroUKinima />} />
        <Route path="/arhiva" element={<Arhiva />} />
        <Route path="/novosti" element={<Novosti />} />
        <Route path="/novosti/iz-svijeta-filma" element={<IzSvijetaFilma />} />
        <Route path="/novosti/traileri" element={<TrejleriNovosti />} />
        <Route path="/search" element={<Search />} />
        <Route path="*" element={<Home />} />
        
      </Routes>
    </Router>
  )
}

export default App
