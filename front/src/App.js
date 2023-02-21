import {BrowserRouter, Route, Routes} from 'react-router-dom';
import Login from './pages/Security/Login';
import './assets/css/commons.css'
import Register from './pages/Security/Register';
import MesColocs from './pages/MesColoc';
function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<MesColocs />} />
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
