// const gameData = [
//   {
//     id: 1,
//     title: "Cryber Punck",
//     category: "Action",
//     releaseDate: "Dec 19, 2014",
//     img: "./imgs/img-1.jpg",
//     price: "Free",
//   },

// {
//     id: 2,
//     title: "EA SPORTS FC™",
//     category: "Sports",
//     releaseDate: "29 Sep, 2023",
//     img: "./imgs/img-2.jpg",
//     price: "$69.99 USD",
//   },
//   {
//     id: 3,
//     title: "Lies of P",
//     category: "Action",
//     releaseDate: "18 Sep, 2023",
//     img: "./imgs/img-3.jpg",
//     price: "$59.99 USD",
//   },
//   {
//     id: 4,
//     title: "Apex Legends™",
//     category: "Action",
//     releaseDate: "5 Nov, 2020",
//     img: "./imgs/img-4.jpg",
//     price: "Free",
//   },
//   {
//     id: 5,
//     title: "War Thunder",
//     category: "Action",
//     releaseDate: "15 Aug, 2013",
//     img: "./imgs/img-5.jpg",
//     price: "Free",
//   },
//   {
//     id: 6,
//     title: "Grand Theft Auto V",
//     category: "Action",
//     releaseDate: "14 Apr, 2015",
//     img: "./imgs/img-6.jpg",
//     price: "$20.61 USD",
//   },
//   {
//     id: 7,
//     title: "Farlight 84",
//     category: "Action",
//     releaseDate: "21 Sep, 2023",
//     img: "./imgs/img-7.jpg",
//     price: "Free",
//   },
//   {
//     id: 8,
//     title: "Resident Evil 4",
//     category: "Action",
//     releaseDate: "24 Mar, 2023",
//     img: "./imgs/img-8.jpg",
//     price: "$59.99 USD",
//   },
//   {
//     id: 9,
//     title: "The Elder Scrolls",
//     category: "Adventure",
//     releaseDate: "4 Apr, 2014",
//     img: "./imgs/img-9.jpg",
//     price: "$19.99 USD",
//   },
//   {
//     id: 10,
//     title: "Forza Horizon 5",
//     category: "Racing",
//     releaseDate: "9 Nov, 2021",
//     img: "./imgs/img-11.jpg",
//     price: "$32.78 USD",
//   },
//   {
//     id: 11,
//     title: "DiRT Rally 2.0",
//     category: "Racing",
//     releaseDate: "26 Feb, 2019",
//     img: "./imgs/img-12.jpg",
//     price: "$04.99 USD",
//   },
//   {
//     id: 12,
//     title: "BeamNG.drive",
//     category: "Simulator",
//     releaseDate: "29 May, 2015",
//     img: "./imgs/img-13.jpg",
//     price: "$04.99 USD",
//   },
//   {
//     id: 13,
//     title: "Need for Speed™ Heat",
//     category: "Racing",
//     releaseDate: "8 Nov, 2019",
//     img: "./imgs/img-14.jpg",
//     price: "$24.99 USD",
//   },
//   {
//     id: 14,
//     title: "SnowRunner",
//     category: "Simulator",
//     releaseDate: "8 Nov, 2019",
//     img: "./imgs/img-15.jpg",
//     price: "$23.99 USD",
//   },
//   {
//     id: 15,
//     title: "Cities: Skylines",
//     category: "Simulator",
//     releaseDate: "10 Mar, 2015",
//     img: "./imgs/img-16.jpg",
//     price: "$12.99 USD",
//   },
//   {
//     id: 16,
//     title: "Farming Simulator 22",
//     category: "Simulator",
//     releaseDate: "22 Nov, 2021",
//     img: "./imgs/img-17.jpg",
//     price: "$39.99 USD",
//   },
//   {
//     id: 17,
//     title: "Hearts of Iron IV",
//     category: "Adventure",
//     releaseDate: "6 Jun, 2016",
//     img: "./imgs/img-18.jpg",
//     price: "$16.99 USD",
//   },
//   {
//     id: 18,
//     title: "Assetto Corsa",
//     category: "Racing",
//     releaseDate: "19 Dec, 2014",
//     img: "./imgs/img-19.jpg",
//     price: "$16.99 USD",
//   },
// ];


const productContainer = document.querySelector(".products_wrapper");
const ulEl = document.querySelector("ul");
const btnEl = document.querySelector(".btn_search");
const inputEl = document.querySelector(".form_control");

// display all dynamic data
window.addEventListener("DOMContentLoaded", () => {
  displayGameData(gameData);
  //getting unique category
  const categories = gameData.reduce(
    function (values, item) {
      if (!values.includes(item.category)) {
        values.push(item.category);
      }
      return values;
    },
    ["All"],
  );
  const categoryBtns = categories
    .map(function (category) {
      return `<li><a href="#" data-id="${category}">${category}</a></li>`;
    })
    .join("");
  ulEl.innerHTML = categoryBtns;
  // links
  const linksEl = document.querySelectorAll("li a");
  linksEl.forEach((links) => {
    links.addEventListener("click", (e) => {
      const category = e.target.dataset.id;
      const gameCategory = gameData.filter(function (data) {
        if (data.category === category) {
          return data;
        }
      });
      if (category === "All") {
        displayGameData(gameData);
      } else {
        displayGameData(gameCategory);
      }
    });
  });
});
// function display all games
function displayGameData(gamez) {
  let displayData = gamez.map(function (cat_items) {
    return `<div class="products">
            <div class="pr_img">
              <img src="${cat_items.img}" alt="" />
            </div>
            <div class="content">
              <h3 class="title">${cat_items.title}</h3>
              <p class="release_date">Realse Date: ${cat_items.releaseDate}</p>
              <p class="price">Price: ${cat_items.price}</p>
            </div>
          </div>`;
  });
  displayData = displayData.join("");
  productContainer.innerHTML = displayData;
}
// search
btnEl.addEventListener("click", (e) => {
  let searchValue = inputEl.value;
  if (searchValue !== "") {
    let searchCategory = gameData.filter(function (data) {
      if (data.title.includes(searchValue)) {
        return data;
      } else if (data.category.includes(searchValue)) {
        return data;
      }
    });
    if (searchCategory) {
      displayGameData(searchCategory);
    }
    inputEl.value = "";
  } else {
    alert("Please Search The Category or Title !");
  }
});rent