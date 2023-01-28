import React from "react";
import { Link } from "react-router-dom";
import iconOption from "../../assets/images/icons/icon-option-depenses.svg";
import NavBarToggle from "../../components/navBar/NavBarToggle";
const NameColoc = () => {
  const options = [
    {
      label: "modifier",
      value: "update",
    },

    {
      label: "supprimer",
      value: "delete",
    },
  ];

  const items = [
    {
      id: 1,
      name: "titre depense",
      pseudo: "bread",
      price: "102$",
    },
    {
      id: 1,
      name: "titre depense",
      pseudo: "bread",
      price: "102$",
    },
    {
      id: 1,
      name: "titre depense",
      pseudo: "bread",
      price: "102$",
    },
    {
      id: 1,
      name: "titre depense",
      pseudo: "bread",
      price: "102$",
    },
    {
      id: 1,
      name: "titre depense",
      pseudo: "bread",
      price: "102$",
    },
    {
      id: 1,
      name: "titre depense",
      pseudo: "bread",
      price: "102$",
    },
    {
      id: 1,
      name: "titre depense",
      pseudo: "bread",
      price: "102$",
    },
  ];
  
  
   /*var btnOption = document.getElementsByClassName("image-option");
    var modaleOption = document.getElementsByClassName("option-box");
    for (var i = 0; i < btnOption.length; i++) {
        btnOption[i].addEventListener('click', function () {
            console.log('click');
            //modaleOption[i].classList.add("active");
        });
    }*/


    /*const handleOption = (id) => {
        console.log(id);
        const modaleOption = document.querySelectorAll(".option-box");
        for (let i = 0; i < modaleOption.length; i++) {
            modaleOption[i].classList.add("active");
        }
    }*/

    /*const handleDeleteDepense = (id) => {
        console.log(id);
    }*/

    /*var coll = document.getElementsByClassName('image-option');
    console.log(coll);
    var i;
    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener('click', function () {
            console.log(coll);
            this.classList.toggle('active');
            var content = this.nextElementSibling;
            if (content.style.display === 'block') {
                content.style.display = 'none';
            } else {
                content.style.display = 'block';
            }
        });
    }*/
    const handleOption = event => {
        event.currentTarget.nextElementSibling.classList.add('active');
    };



    const modaleOption = document.querySelectorAll(".option-box");
    var btnOption = document.querySelectorAll(".image-option");

    /*for (let i = 0; i < modaleOption.length; i++) {
        window.addEventListener("click", (event) => {
            const isClickInside = modaleOption.contains(event.target);
            if (!isClickInside) {
                modaleOption[i].nextElementSibling.classList.remove("active");
            }
        })
    }*/

    /*window.addEventListener("click", (event) => {
        console.log("test");
        const isClickInside = modaleOption.contains(event.target);
        if (!isClickInside) {
            modaleOption.classList.remove("active");
        }
    });*/
return (

    <div className="vh-100 page page-depenses">
        <NavBarToggle />
        <div className="depenses-container">
            <h1 className="">Nom Coloc</h1>
            <Link to="/ajout-remboursement" className="bloc-btn btn-icon btn-add-depense">
              <button>Ajouter une dépense</button>
            </Link>
            <Link to="/ModaleDepense">
              <div className="depenses-list">
                  {items.map((item) =>
                      <div className="box-model" key={item.id}>
                          <div className="option-text">
                              <p className="para-20 bold">{item.name} </p>
                              <p className="para-16">Payé par {item.pseudo} </p>
                          </div>
                          <div className="depense-price">
                              <p className="para-30 satoshi-bold">{item.price}€</p>
                              <div className="image-option" onClick={handleOption}>
                                  <img src={iconOption}/>
                              </div>
                              <div className="box-model box-shadow-1 option-box">
                                  {options.map((option) => (
                                      <p value={option.value}>{option.label}</p>
                                  ))}
                              </div>
                          </div>
                      </div>
                  )}
              </div>
            </Link>
        </div>
    </div>
)
};
{/*onClick={() => handleOption(item.id)}*/}
export default NameColoc;