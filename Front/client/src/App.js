import React from "react";
import './assets/css/reset.css';
import './assets/css/texts.css';
import './assets/css/components/buttons.css';
import './assets/css/components/box.css';
import './assets/css/components/photo-profile.css';
import './assets/css/pages/page-home.css';
import './assets/css/pages/page-depenses.css';
import './assets/css/pages/page-login-register.css';
import './assets/css/modales/modale-mes-colocs.css';
import './assets/css/modales/modale-add-modify-remboursement-depense.css';
import Login from './pages/Login/Login';
import Register from './pages/Register/Register';
import AddColoc from './pages/mesColocs/AddColoc';
import Home from './pages/Home/Home';
import NameColoc from './pages/NameColoc/NameColoc';
import EquilibreDepenses from './pages/EquilibreDepenses';
import MonProfil from "./modales/modalMonProfil";
import ModaleDepense from "./modales/modaleDepense";
import ModaleAddRemboursement from "./modales/modaleAddRemboursement";
import Coloc from "./components/coloc/Coloc"
import NavBar from './components/navBar/NavBar';
import ReactDOM from 'react-dom/client';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import NavBarToggle from "./components/navBar/NavBarToggle";
import ModalParticipants from "./modales/modalParticipants";

function App() {
  return (
      <BrowserRouter>
          <div className="App">
                <NavBar />
          </div>
          <Routes>
              <Route path='/' element={<Home />} />
              {/* <Route path='/mesColocs' element={<Home />} /> */}
              <Route path='/NameColoc/:id' element={<NameColoc />} />
              <Route path='/EquilibreDepenses' element={<EquilibreDepenses />} />
              <Route path='/AddColoc' element={<AddColoc />} />
              <Route path='/ModaleDepense' element={<ModaleDepense />} />
              <Route path='/login' element={<Login />} />
              <Route path='/register' element={<Register />} />
              <Route path='/MonProfil' element={<MonProfil />} />
              <Route path='/participants' element={<ModalParticipants />} />
              <Route path='/ajout-remboursement' element={<ModaleAddRemboursement />} />
          </Routes>
      </BrowserRouter>
  );
}

export default App;
