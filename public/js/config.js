"use strict";
var base = {
        defaultFontFamily: "Overpass, sans-serif",
        primaryColor: "#1b68ff",
        secondaryColor: "#4f4f4f",
        successColor: "#3ad29f",
        warningColor: "#ffc107",
        infoColor: "#17a2b8",
        dangerColor: "#dc3545",
        darkColor: "#343a40",
        lightColor: "#f2f3f6",
    },
    extend = {
        primaryColorLight: tinycolor(base.primaryColor).lighten(10).toString(),
        primaryColorLighter: tinycolor(base.primaryColor)
            .lighten(30)
            .toString(),
        primaryColorDark: tinycolor(base.primaryColor).darken(10).toString(),
        primaryColorDarker: tinycolor(base.primaryColor).darken(30).toString(),
    },
    chartColors = [
        base.primaryColor,
        base.successColor,
        "#6f42c1",
        extend.primaryColorLighter,
    ],
    colors = {
        bodyColor: "#6c757d",
        headingColor: "#495057",
        borderColor: "#e9ecef",
        backgroundColor: "#f8f9fa",
        mutedColor: "#adb5bd",
        chartTheme: "light",
    },
    darkColor = {
        bodyColor: "#adb5bd",
        headingColor: "#e9ecef",
        borderColor: "#212529",
        backgroundColor: "#495057",
        mutedColor: "#adb5bd",
        chartTheme: "dark",
    },
    curentTheme = localStorage.getItem("mode"),
    dark = document.querySelector("#darkTheme"),
    light = document.querySelector("#lightTheme"),
    switcher = document.querySelector("#modeSwitcher");
function modeSwitch() {
    console.log("abc");
    var o = localStorage.getItem("mode");
    o
        ? "dark" == o
            ? ((dark.disabled = !0),
              (light.disabled = !1),
              localStorage.setItem("mode", "light"))
            : ((dark.disabled = !1),
              (light.disabled = !0),
              localStorage.setItem("mode", "dark"))
        : $("body").hasClass("dark")
        ? ((dark.disabled = !1),
          (light.disabled = !0),
          localStorage.setItem("mode", "dark"))
        : ((dark.disabled = !0),
          (light.disabled = !1),
          localStorage.setItem("mode", "light"));
}
