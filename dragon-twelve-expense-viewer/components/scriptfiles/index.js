$(document).ready( function () {
    $('.exTable').DataTable();

    new DataTable('.billingTable',{
        autoWidth:false
    });

    $('#expenseModal').modal("show");
    $('#particularModal').modal("show");   
});

const numberOfParagraph = document.querySelectorAll(".side-bar .row div ul li").length

function paragraphMisionVision(){

    for (var i = 0;i<numberOfParagraph;i++){
        document.querySelectorAll(".side-bar .row div ul li")[i]
    
    }
    var buttonInnerHTML = this.innerHTML;
    
    switch(buttonInnerHTML){
        case "HISTORY":
            $(".side-bar .row div p").slideUp().fadeOut();
            $(".side-bar .row div p").html("<span>''</span>Dragon Twelve Builders and Construction Supply were founded by businessman Jonathan L. Diaz. In year 2010 the company started as an aggregate supplier at Brgy. Arusip, Ilagan, Isabela. Through the years, it began to expand its services. It was fully established in the year 2015. The company was certified by Philippine Contractors Accreditation Board (PCAB) as registered contractor for government projects with AA category; it was accredited to accept government projects and to supply concrete and mortar mixes. Over the years the company provides superior services to contractors and other industries.<span>''</span>");
            $(".side-bar .row div p").slideDown().fadeIn();
         break;
        
        case "MISION":
            $(".side-bar .row div p").slideUp().fadeOut();
            $(".side-bar .row div p").html("<span>''</span>Dragon Twelve Builders and Construction Supply is dedicated to provide quality construction, technical and management services to our customers and maintaining the highest level of professionalism, integrity, honesty, and fairness in our relationship with our suppliers, subcontractors, professional associates based on safety, quality, timely service and anticipation of their needs as per Department of Public Works and Highways (DPWH) standard specification requirements.<span>''</span>");
            $(".side-bar .row div p").slideDown().fadeIn();
        break;
    
       case "VISION":
            $(".side-bar .row div p").slideUp().fadeOut();$(".side-bar .row div p").html("");
            $(".side-bar .row div p").html("<span>''</span>Dragon Twelve Builders and Construction Supply is committed in becoming the contractor of choice, pursuing excellence through dedication, experience and disciplined employees with ongoing passion to deliver safety standards, quality ready mix, timely and profitable projects.<span>''</span>");
            $(".side-bar .row div p").slideDown().fadeIn();
        break;
    
        default: console.log(buttonInnerHTML);
    }
    
}

for (var i = 0;i<numberOfParagraph;i++){
document.querySelectorAll(".side-bar .row div ul li")[i].addEventListener("click",paragraphMisionVision)
}