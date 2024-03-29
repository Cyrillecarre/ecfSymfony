document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.etoile');
    const star1 = document.getElementById('etoile1');
    const star2 = document.getElementById('etoile2');
    const star3 = document.getElementById('etoile3');
    const star4 = document.getElementById('etoile4');
    const star5 = document.getElementById('etoile5');

    star1.addEventListener('click', function() {
        star2.classList.remove('inputClic');
        star3.classList.remove('inputClic');
        star4.classList.remove('inputClic');
        star5.classList.remove('inputClic');
        document.getElementById('review_count').value = 1;
    });

    star2.addEventListener('click', function() {
        console.log("Star 2 clicked");
        star1.classList.add('inputClic');
        star3.classList.remove('inputClic');
        star4.classList.remove('inputClic');
        star5.classList.remove('inputClic');
        document.getElementById('review_count').value = 2;
    });

    star3.addEventListener('click', function() {
        star1.classList.add('inputClic');
        star2.classList.add('inputClic');
        star4.classList.remove('inputClic');
        star5.classList.remove('inputClic');
        document.getElementById('review_count').value = 3;
    });

    star4.addEventListener('click', function() {
        star1.classList.add('inputClic');
        star2.classList.add('inputClic');
        star3.classList.add('inputClic');
        star5.classList.remove('inputClic');
        document.getElementById('review_count').value = 4;
    });

    star5.addEventListener('click', function(){
        star1.classList.add('inputClic');
        star2.classList.add('inputClic');
        star3.classList.add('inputClic');
        star4.classList.add('inputClic');
        document.getElementById('review_count').value = 5;
    });


    stars.forEach(function(star) {
        star.addEventListener('click', function() {
            const value = parseInt(star.getAttribute('data-value'));
            document.getElementById('review_count').value = value;


            stars.forEach(function(s) {
                const sValue = parseInt(s.getAttribute('data-value'));
                if (sValue <= value) {
                    s.classList.add('inputClic');
                } else {
                    s.classList.remove('inputClic');
                }
            });
        });
    });
});

function burger(){
    const burgerMenu = document.getElementById('burger-menu');
    const navList = document.querySelectorAll('.navListe');

    burgerMenu.addEventListener('click', function() {
      console.log('click');
        navList.forEach(item => {
            item.classList.toggle('show');
        });
    });
  }
  burger();
