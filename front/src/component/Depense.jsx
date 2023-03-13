import '../assets/css/components/depense.css'
import DepenseRow from './DepenseRow';
import AddDepense from './modal/AddDepense';
import { useState } from 'react';

const Depense = (props) => {
    const chargeInfo = props.chargeInfo;
    const colocationInfo = props.colocationInfo;
    const userInfo = props.userInfo;

    const [isModalOpen, setIsModalOpen] = useState(false);

    const handleOpenModal = () => {
      setIsModalOpen(true);
      document.body.classList.add("no-scroll");
    };

    const handleCloseModal = () => {
      setIsModalOpen(false);
      document.body.classList.remove("no-scroll");
    };

    return (
        <div className='macoloc-content'>

          {/* <Dropdown/> */}
          {isModalOpen &&(
            <AddDepense onClose={handleCloseModal} userInfo={userInfo} colocationInfo={colocationInfo}/>
          )}
          <div className="macoloc-header">
            <h2 className='macoloc-title'>{colocationInfo.colocation_name}</h2>
            <button className="btn" onClick={handleOpenModal}>Ajouter une dépense</button>
          </div>
          {chargeInfo.map((charge, index) => (
            // Render each charge item here
            <DepenseRow charge={charge} key={index} datakey={index}/>
          ))}
        </div>
        
      );
      
}

export default Depense