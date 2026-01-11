<template>
    <div id="body">
        <div id="container">
            <div>
                <h1>suprem banan! Like 30% off or so...</h1>
            </div>
            <div id="bananacontainer">
                <img id="banana" src="../components/images/banana.svg" />
                <div id="pricetag">
                    <p>299$</p>
                    <p style="text-decoration: line-through; font-size: 100px">
                        700$
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup></script>

<style scoped>
@font-face {
    font-family: rocket-thunder;
    src: url(../css/rocket-thunder-shadow.ttf);
}
#body {
    width: 100%;
    height: auto;
    height: calc(100dvh - 100px);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    display: flex;
    align-items: center;
}
#container {
    background-color: white;
    width: 60%;
    height: 100%;
    margin: 200px;
    border-radius: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}
h1 {
    color: black;
    margin: 0;
    padding: 1rem;
}
#bananacontainer {
    background-image: url(../components/images/icons/diamond-X-shape.svg);
    background-repeat: no-repeat;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}
#banana {
    width: 550px;
}
#pricetag {
    position: absolute;
    color: rgb(236, 55, 0);
    transform: rotate(20deg);
    display: flex;
    align-items: center;
    justify-content: center;
    top: 50%;
    left: 40%;
    margin-left: -80px;
    margin-top: -80px;
}
p {
    font-size: 150px;
    text-shadow: #000000 4px 0 5px;
    font-family: rocket-thunder;
}
</style>
