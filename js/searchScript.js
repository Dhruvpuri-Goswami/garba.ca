const searchBars = document.querySelector('.searchBar');

searchBars.addEventListener('input', async(event) => {
    let name = event.target.value;
    let cards = document.querySelectorAll('.card-folders');
    
    cards.forEach(items => {
        const heading = items.querySelector('.title');

        // const description = items.querySelector('.loc');
        
        // if (heading.textContent.toLowerCase().includes(name) || description.textContent.toLowerCase().includes(name)) {
        //     items.style.display = 'block';
        // } else {
        //     items.style.display = 'none';
        // }
    });
});


let titles = document.querySelectorAll('.title')

titles.forEach(title => {
    let working = title.innerHTML;
    let words = working.trim();
    if(words.length >= 15){
        let newSen = words.slice(0, 15) + '...';
        title.innerHTML = newSen;
    }
});

let loc = document.querySelectorAll('.loc')

loc.forEach(location => {
    let address = location.innerHTML;
    address = address.trim()
    if(address.length >= 15){  
        let newAddress = address.slice(0, 25) + '...';
        location.innerHTML = newAddress;
    }
});
