(function () {
    function addHeaderInTop (e) {
        let coordY = window.pageYOffset;
        let headerEl = document.querySelector('header');
        if (coordY > 0 && !headerEl.classList.contains('active')) {
            headerEl.classList.add('active');
        } else if (coordY <= 0 && headerEl.classList.contains('active')) {
            headerEl.classList.remove('active');
        }
    }
    document.addEventListener('scroll', addHeaderInTop);
	if (window.innerWidth < 991) {
	//обработчик нопки на телефонах
		document.querySelector('header').addEventListener('click', function (e) {
			if (e.target.classList.contains('hamburger')) {
				document.querySelector('header nav').classList.toggle('active');
			}
			if (e.target.classList.contains('fa-phone-volume')) {
				document.querySelector('header .header-info').classList.toggle('active');
			}
		});
	}
// обработка вкл/выкл параллакса
	let paralaxImg = document.querySelector('.parallax');
	let elInstructionDescription = document.querySelector('.instruction-description');
	function addImgSrcScrollHandler(e) {
		let coord = window.innerHeight - elInstructionDescription.getBoundingClientRect().top;
		if ((coord < -224.75 &&  coord < 1475 || coord > 1475) && paralaxImg.classList.contains('active')) {
			paralaxImg.classList.remove('active');
			console.log('false - ' + coord);
		} else if ((coord > -224.75 &&  coord < 1475) && !paralaxImg.classList.contains('active')) {
			paralaxImg.classList.add('active');
		}
	}
	document.addEventListener('scroll', addImgSrcScrollHandler);

	if (window.innerWidth > 425) {
	//обработчик Анимации графика
		function addClassScrollHandler(e) {
			let diagram = document.querySelector('.diagram:first-of-type');
			let coord = window.innerHeight - diagram.getBoundingClientRect().top;
			if (coord > -20 && !diagram.classList.contains('active')) {
				diagram.classList.add('active');
				diagram.removeEventListener('scroll', addClassScrollHandler);
			}
		}
		document.addEventListener('scroll', addClassScrollHandler);
	//обработчик скролл Истории
	    let commentSection = jQuery('.guest-stories');
	    if( commentSection.length )
    		document.querySelector('.guest-stories').addEventListener('click', function (e) {
    			if (e.target.tagName.toLowerCase() === "path" && e.target.parentElement.parentElement.parentElement.classList.contains('arrow-left')) {
    				document.querySelector('.wrapper-stories').scrollBy({
    				    left: -345,
    				    behavior: "smooth"
    				});
    			} else if (e.target.tagName.toLowerCase() === "path" && e.target.parentElement.parentElement.parentElement.classList.contains('arrow-right')) {
    				document.querySelector('.wrapper-stories').scrollBy({
    				    left: 345,
    				    behavior: "smooth"
    				});
    			} 
    		});
	//обработчик Получить приглашение
		document.querySelector('.invite-button').addEventListener('click', function (e) {
			let wrapperInvite = document.querySelector('.registration-description-bottom');
			wrapperInvite.classList.add('active');
			wrapperInvite.addEventListener('click', function(e) {
				if (e.target.classList.contains('close') || e.target.classList.contains('registration-description-bottom')) {
					wrapperInvite.classList.remove('active');
				}
			});
		});
	} else {
	//обработчик Анимации графика (мобилка)
		function addClassScrollHandler(e) {
			let diagram = document.querySelector('.diagram-mob');
			let coord = window.innerHeight - diagram.getBoundingClientRect().top;
			if (coord > 50 && !diagram.classList.contains('active')) {
				diagram.classList.add('active');
				console.log(coord)
				diagram.removeEventListener('scroll', addClassScrollHandler);
			}
		}
		document.addEventListener('scroll', addClassScrollHandler);
	}
	//обработчик большие Фото
	let photos = jQuery('.photo-items');
	if( photos.length )
    	document.querySelector('.photo-items').addEventListener('click', function (e) {
    		let wrapperPhoto = document.querySelector('.background-photo');
    		if (e.target.tagName.toLowerCase() === 'img') {
    			document.querySelector('.background-photo img').setAttribute('src', e.target.attributes[0].value);
    			wrapperPhoto.classList.add('active');
    			wrapperPhoto.addEventListener('click', function(e) {
    				if (e.target.classList.contains('close') || e.target.classList.contains('background-photo')) {
    					wrapperPhoto.classList.remove('active');
    				}
    			});
    		}
    	});
	//обработчик обратный звонок
	document.querySelector('#button-back-call').addEventListener('click', function (e) {
		let wrapperBackCall = document.querySelector('.registration-back-call');
		wrapperBackCall.classList.add('active');
		wrapperBackCall.addEventListener('click', function(e) {
			if (e.target.classList.contains('close') || e.target.classList.contains('registration-back-call')) {
				wrapperBackCall.classList.remove('active');
			}
		});
	});
	// ajax отправка форм
    function addMail(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
        	let formData = new FormData(form);
        	let xhr = new XMLHttpRequest();
        	xhr.open('POST', 'mail.php');
        	xhr.onload = function(evt) {
            if (xhr.status == 200) {
                alert("Отправлено");
                for(let i = form.length - 1; i> -1;i--) {
                    if (form[i].type === "radio" || form[i].type === "submit") continue;
                    form[i].value='';
                }
            } else {
                alert("К сожалению произошла ошибка - " + evt.status);
            }
          };
        	xhr.send(formData);
        });
    }
    let form1 = document.forms.namedItem('registrationTop');
    let form2 = document.forms.namedItem('registrationBottom');
    let form3 = document.forms.namedItem('registrationPopup');
    let form4 = document.forms.namedItem('registrationBackCall');
    addMail(form1);
    addMail(form2);
    addMail(form3);
    addMail(form4);
    //обработчик ЧаВо
    setTimeout(function() {
    	let wrapperFAQ = document.querySelector('.wrapper-FAQ');
    	let FAQitemsHeight = document.querySelectorAll('.wrapper-FAQ .items .answer');
    	let arrHeight = [];
    	for (let i = FAQitemsHeight.length - 1; i > -1 ; i--) {
    		FAQitemsHeight[i].setAttribute('style', 'height: auto;');
    		arrHeight.unshift(FAQitemsHeight[i].offsetHeight);
    		FAQitemsHeight[i].setAttribute('style', '');
    	}
    	function sowEl(e, num) {
    		let elem = e.nextElementSibling;
    	    elem.setAttribute('style', 'height:'+arrHeight[num]+'px;');
    	}
    	wrapperFAQ.addEventListener('click', function (e) {
    		if (e.target.tagName.toLowerCase() === 'h3') {
    			if (!e.target.parentElement.classList.contains('active')) {
    				let FAQitems = document.querySelectorAll('.wrapper-FAQ .items .answer');
    				let num = 0;
    				for (let i = FAQitems.length - 1; i > -1; i--) {
    					if (e.target.nextElementSibling === FAQitems[i]) {
    						num = i;
    					}
    					if (FAQitems[i].parentElement.classList.contains('active')) {
    						FAQitems[i].parentElement.classList.remove('active');
    						FAQitems[i].setAttribute('style', 'height:0px;');
    					}
    	            }
    	            sowEl(e.target, num);
    				e.target.parentElement.classList.add('active');
    	        }
    	    }
    	}); 
    	document.querySelector('.wrapper-FAQ .item-1 h3').click();
    },1000);
})();
$(function(){
  $('#registration-form [type="tel"]').mask("+375(99) 999-99-99");
  $('#registration-form [name="age"]').mask("99");
  $('#registration-form-footer [type="tel"]').mask("+375(99) 999-99-99");
  $('#registration-form-footer [name="age"]').mask("99");
  $('#registration-form-bottom [type="tel"]').mask("+375(99) 999-99-99");
  $('#registration-form-bottom [name="age"]').mask("99");
  $('#registration-form-back-call [type="tel"]').mask("+375(99) 999-99-99");
});
$(document).ready(function(){
    $('header nav').on("click","a", function (event) {
        event.preventDefault();
        let id  = $(this).attr('href'),
            top = $(id).offset().top;
        $('body,html').animate({scrollTop: top}, 1500);
    });
});
