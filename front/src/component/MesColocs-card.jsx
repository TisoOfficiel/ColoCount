import '../assets/css/components/MesColocs-card.css';
import { Link } from 'react-router-dom'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {faArrowRight} from "@fortawesome/free-solid-svg-icons";

const Colocs = () => {
  return (
    <div>
      <div className="coloc-container">
          <h2 className="coloc-title">Nom de la Coloc</h2>
          <p className="coloc-description">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, 
          </p>
          <div className="bottom">
            <small className="coloc-date">Crée le 12/01/23</small>
            <Link to="/test" className="link-coloc"><span><FontAwesomeIcon icon={faArrowRight} /></span></Link>
          </div>
      </div>
      
    </div>
  )
}

export default Colocs