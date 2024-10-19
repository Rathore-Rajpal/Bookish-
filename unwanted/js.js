const gameData = [
    {
      id: 1,
      title: "Iphone 15 pro max",
      category: "Smartphone",
      releaseDate: "Dec 19, 2014",
      img: "apple-iphone-15-pro-max.jpg",
      price: "₹-149000",
    },
    {
      id: 3,
      title: "Iphone 15",
      category: "Smartphone",
      releaseDate: "18 Sep, 2023",
      img: "apple-iphone-15.jpg",
      price: "₹-79000",
    },
    {
      id: 4,
      title: "Google pixel 8pro™",
      category: "Smartphone",
      releaseDate: "5 Nov, 2020",
      img: "google-pixel-8-pro.jpg",
      price: "₹-106000",
    },
    {
      id: 5,
      title: "Google pixel 8",
      category: "Smartphone",
      releaseDate: "15 Aug, 2013",
      img: "google-pixel-8.jpg",
      price: "₹-850000",
    },
    {
      id: 6,
      title: "Samsung galaxy S23 ultra",
      category: "Smartphone",
      releaseDate: "14 Apr, 2015",
      img: "samsung-galaxy-s23-ultra-5g.jpg",
      price: "₹-126000",
    },
    {
      id: 7,
      title: "Samsung galaxy S23 ",
      category: "Smartphone",
      releaseDate: "21 Sep, 2023",
      img: "samsung-galaxy-s23-5g.jpg",
      price: "₹-74000",
    },
    {
      id: 8,
      title: "ROG 8 pro",
      category: "Smartphone",
      releaseDate: "24 Mar, 2023",
      img: "asus-rog-phone-8-pro.jpg",
      price: "₹-94000",
    },
    {
      id: 2,
      title: "Samsung QA98QN90A 98 Inch LED 4K",
      category: "TELEVISION",
      releaseDate: "29 Sep, 2023",
      img: "tv.jpg",
      price: "₹245000",
    },
    {
      id: 10,
      title: "Asus ROG Zephyrus Duo 16",
      category: "Laptop",
      releaseDate: "9 Nov, 2021",
      img: "asus_rog.jpg",
      price: "₹250000",
    },
    {
      id: 11,
      title: "Asus ZenBook Pro Duo 15 ",
      category: "Laptop",
      releaseDate: "26 Feb, 2019",
      img: "asus.jpg",
      price: "₹-233000",
    },
    {
      id: 13,
      title: "MSI GE66 Raider 11UE",
      category: "Laptop",
      releaseDate: "8 Nov, 2019",
      img: "msi.jpg",
      price: "₹340000",
    },
    {
      id: 18,
      title: "MSI Titan GT77 HX",
      category: "Laptop",
      releaseDate: "19 Dec, 2014",
      img: "laptop 1.jpg",
      price: "₹-499000",
    },
    {
      id: 12,
      title: "NOISE",
      category: "Headphones",
      releaseDate: "29 May, 2015",
      img: "noise-two-wireless-on-ear-bluetooth-v5-3-headphones-with-50-hours-playtime-serene-blue-.jpg",
      price: "₹-3500",
    },
    {
      id: 14,
      title: "boat rockerz 450",
      category: "Headphones",
      releaseDate: "8 Nov, 2019",
      img: "boat-rockerz-450-bluetooth-headphone-luscious-black-.jpg",
      price: "₹-1550",
    },
    {
      id: 15,
      title: "boat airdopes 138",
      category: "Headphones",
      releaseDate: "10 Mar, 2015",
      img: "boat-airdopes-138-bluetooth-v5-0-in-ear-truly-wireless-earbuds-with-mic-viper-green-.jpg",
      price: "₹-1800",
    },
    {
      id: 16,
      title: "apple airpods pro (2nd gen)",
      category: "Headphones",
      releaseDate: "22 Nov, 2021",
      img: "apple-airpods-pro-2nd-gen-with-usb-type-c-white-.jpg",
      price: "₹-23000",
    },
    {
      id: 9,
      title: "SONY Alpha ILCE-1/BQ IN5 Mirrorless Camera",
      category: "camera",
      releaseDate: "4 Apr, 2014",
      img: "sony.webp",
      price: "₹4-99000",
    },
    {
      id: 17,
      title: "SONY Alpha Alpha 1 Mirrorless Camera",
      category: "camera",
      releaseDate: "6 Jun, 2016",
      img: "sony2.webp",
      price: "₹-513000",
    },
  ];





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
});