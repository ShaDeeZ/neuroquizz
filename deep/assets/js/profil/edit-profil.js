function changeDescription(event){
    let div_all_categories = event.target.closest('.div_all_categories')
    let icon_chevron = div_all_categories.getElementsByClassName('fa-circle-chevron-down')[0]
    let div_more_info = div_all_categories.getElementsByClassName('div_more_info_categories')[0]

    icon_chevron.classList.toggle('fa-circle-chevron-up')
    div_more_info.classList.toggle('none')
}