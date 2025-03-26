var Links = {
  setColor:function(color){
    var alist = document.querySelectorAll('a');
    var i = 0;
    while(i < alist.length){
      alist[i].style.color = color;
      i = i + 1;
    }
  }
}

var Body = {
  setColor:function (color){
    document.querySelector('body').style.color = color;
  },
  setBackgroundColor:function (color){
    document.querySelector('body').style.backgroundColor = color;
  }
}
function nightDayHandler(self){
  var target = document.querySelector('body');
  if(self.value === 'night'){
    Body.setBackgroundColor('black');
    Body.setColor('white');
    self.value = 'day';
    Links.setColor('powderblue');
  } else {
    Body.setBackgroundColor('white');
    Body.setColor('black');
    self.value = 'night';
    Links.setColor('black');
  }
}

document.addEventListener('DOMContentLoaded', function() {
  // 현재 페이지 링크를 추적하여 색상을 변경
  var currentPath = window.location.pathname.split('/').pop();
  var links = document.querySelectorAll('a.link-color');
  links.forEach(function(link) {
      var href = link.getAttribute('href');
      if (href === currentPath) {
          link.classList.add('current-page-link');
      }
  });
});