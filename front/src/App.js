import {BrowserRouter, Route, Routes } from 'react-router-dom';
import Login from './pages/Security/Login';
import './assets/css/commons.css'
import Register from './pages/Security/Register';
import MesColocs from './pages/MesColocs';
import PrivateRoute from './pages/Security/PrivateRoute';
import MaColoc from './pages/MaColoc';
function App() {

  return (
    <BrowserRouter>
      <Routes>
      
        <Route path="/" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route element={<PrivateRoute />}>
          <Route  path="/mesColocs" element={<MesColocs/>}  />
          <Route  path="/mes_colocs" element={<MesColocs/>}  />
          <Route  path="/mes_colocs/:id" element={<MaColoc/>}  />
        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default App;
