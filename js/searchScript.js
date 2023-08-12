
const searchInput = document.querySelector('.searchBars');

searchInput.addEventListener("input", (event) => {
    const inputValue = event.target.value.toLowerCase();

    let cards = document.querySelectorAll('.item-card');

    cards.forEach((card) => {
        let locElement = card.querySelector('.loc');
        if (locElement) {
            let location = locElement.innerHTML.replace('<i class="fa-solid fa-location-dot"></i>', '').trim();
            
            console.log(location.toLowerCase())
            console.log(inputValue.toLowerCase())
            // Check if the input value is a prefix of the location
            if (location.toLowerCase().includes(inputValue)) {
                card.style.display = 'inline-block';
            } else {
                card.style.display = 'none';
            }
        }
    });
});




let titles = document.querySelectorAll('.title')

titles.forEach(title => {
    let working = title.innerHTML;
    let words = working.trim();
    if(words.length >= 18){
        let newSen = words.slice(0, 18) + '...';
        title.innerHTML = newSen;
    }
});


let loc = document.querySelectorAll('.loc')

loc.forEach(items => {
    let newString = items.innerHTML.replace('<i class="fa-solid fa-location-dot"></i>',' ').trim()
    if(newString.length > 25){
        let newWord = newString.slice(0,25) + '...';
        items.innerHTML= `<i class="fa-solid fa-location-dot"></i> ${newWord}`
    }
})