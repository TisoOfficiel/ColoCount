import '../assets/css/components/mes-colocs-card.css';
import { Link } from 'react-router-dom'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {faArrowRight} from "@fortawesome/free-solid-svg-icons";

const Colocs = (props) => {
  const coloc = props.myProp;
  const dateParts = coloc.created_at.split('-');
  const year = dateParts[0];
  const month = dateParts[1];
  const day = dateParts[2].slice(0, 2);
  return (
    <div>
      <div className="coloc-container">
          <h2 className="coloc-title">{coloc.name}</h2>
          <p className="coloc-description">
           {coloc.description} 
          </p>
          <div className="bottom">
            <small className="coloc-date">Crée le {day}/{month}/{year}</small>
            <Link to={`/mes_colocs/${coloc.id}`} className="link-coloc"><span><FontAwesomeIcon icon={faArrowRight} /></span></Link>
          </div>
      </div>
      
    </div>
  )
}

export default Colocs