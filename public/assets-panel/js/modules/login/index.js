
// $(".btnlogin").on('click', function(event){  
//     //alert ('hello');
//     $('.loader').show();
//     // setTimeout(() => {
//     //     $('.loader').hide();
//     // }, 1000);
// });

const btnlogin = (event) => {
    event.preventDefault();
    const data = new FormData(event.target);
     $('.loader').show();
}