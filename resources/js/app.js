// require('./bootstrap');
import hljs from "highlight.js/lib/core";
import javascript from "highlight.js/lib/languages/javascript";
import xml from "highlight.js/lib/languages/xml";
import css from "highlight.js/lib/languages/css";
import "highlight.js/styles/github.css";

hljs.registerLanguage("javascript", javascript);
hljs.registerLanguage("xml", xml);
hljs.registerLanguage("css", css);
document.addEventListener("DOMContentLoaded", (event) => {
  document.querySelectorAll("pre.code-container code").forEach((block) => {
    hljs.highlightBlock(block);
  });
});

var Turbolinks = require("turbolinks");
Turbolinks.start();

document.addEventListener("turbolinks:load", function() {
  document.querySelectorAll("pre.code-container code").forEach((block) => {
    hljs.highlightBlock(block);
  });
});
