import './App.css'
import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Home from './stranice/Home';
import Film from './stranice/Film';
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



function App() {

  return (
    <Router>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/o-nama" element={<Onama />} />
        <Route path="/film/:id" element={<Film />} />
        <Route path="/kontakt" element={<Kontakt/>} />
        <Route path="/trenutno-u-kinima" element={<TrenutnoUKinima/>} />
        <Route path="/uskoro-u-kinima" element={<UskoroUKinima />} />
        <Route path="/arhiva" element={<Arhiva />} />
        <Route path="/novosti" element={<Novosti />} />
        <Route path="/novosti/iz-svijeta-filma" element={<IzSvijetaFilma />} />
        <Route path="/novosti/trejleri" element={<TrejleriNovosti />} />

        <Route path="*" element={<Home />} />
        
      </Routes>
    </Router>
  )
}

export default App
