h1 {
    color: #000;
    font-family: "Noto_Sans_KR", sans-serif;
    font-size: 36px;
    line-height: 38px;
    font-weight: 700;
    margin: 0;
    padding: 0 0 5px 0;
}

 h2 {
    color: #000;
    text-transform: uppercase;
    font-family: "Noto_Sans_KR", sans-serif;
    font-size: 36px;
    line-height: 38px;
    font-weight: 700;
    margin: 0;
    padding: 0 0 0 0;
}

h3 {
    color: #29abe2;   
    font-family: "Noto_Sans_KR", sans-serif;
    font-size: 18px;
    line-height: 20px;
    font-weight: 700;
    margin: 0;
    padding: 0 0 10px 0;
}

p {
    color: #000;
    font-family: "Noto_Sans_KR", sans-serif;
    font-size: 12px;
    line-height: 14px;
    font-weight: 400;
    margin: 0;
    padding: 0 0 20px 0;
}

ul {
    display: block;
    padding: 0 0 20px 0;
    margin: 0;
    list-style-position: inside;

    li {
        font-family: "Noto_Sans_KR", sans-serif;
        font-size: 12px;
        line-height: 14px;
        font-weight: 400;
    }
}

em {
    color: #000;
    font-family: "Noto_Sans_KR", sans-serif;
     font-size: 12px;
    line-height: 14px;
    font-weight: 400;
    font-style: italic;
}

img {
    display: block;
    line-height: 0;
}

.page {

}
.page-break {
    page-break-before: always;
}

.col-container {
   
}

.col-2 {
    width: 327px;
    position: relative;
    float: left;
}

.col-3 {
    width: 198px;
    position: relative;
    float: left;
}

.col-container .col-2:first-child {
    padding-right: 20px;
}

.col-container .col-2:nth-child(2) {
    padding-left: 20px;
}

.col-container .col-3 {
    padding: 0 20px;
}

.col-container .col-3:first-child {
    padding-left: 0;
}

.col-container .col-3:last-child {
    padding-right: 0;
}

.clear {
    clear: both;
}

a { 
    color: #29abe2;
    text-decoration: underline;
}

.button {
    display: block;
    width: 100%;
    text-align: center;
    border-radius: 6px;
    padding: 10px 10px;
    color: #FFF;
    text-decoration: none;
    font-weight: 700;
}

.button.blue {
    background: #29abe2;
}

.button.orange {
    background: #ea5b0c;
}

.blue-text-block {
    padding: 20px 20px 0 20px;
    border-radius: 6px;
    background: #29abe2;
    margin: 0 0 20px 0;
    position: relative;
}

.blue-text-block:after {
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 15px 15px 15px;
    border-color: transparent transparent #29aae2 transparent;
    display: block;
    top: -15px;
    left: 50%;
    margin-left: 5px;
    content: "";
    position: absolute;
}

.blue-text-block p {
    color: #FFF;
}

.green-color {
    color: #39b54a !important;
}

.blue-color {
    color: #29abe2 !important;
}

.red-color {
    color: #ef4136 !important;
}