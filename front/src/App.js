import {BrowserRouter, Route, Routes } from 'react-router-dom';
import Login from './pages/Security/Login';
import './assets/css/commons.css'
import Register from './pages/Security/Register';
import MesColocs from './pages/MesColocs';
import PrivateRoute from './pages/Security/PrivateRoute';
function App() {

  return (
    <BrowserRouter>
      <Routes>
      
        <Route path="/" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route element={<PrivateRoute />}>
          <Route  path="/mesColocs" element={<MesColocs/>}  />
        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default App;
