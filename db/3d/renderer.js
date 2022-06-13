//set variables
var rotation = 0;

let container;
let camera;
let renderer;
let scene;
let model;
let loader = new THREE.GLTFLoader();

function init(){
  container = document.querySelector(".scene");

  //Create Scene
  scene = new THREE.Scene();
  const fov = 35;
  const aspect = container.clientWidth / container.clientHeight;
  const near = 0.1; //(clipping min)
  const far = 1500; //(render distance)

  //camera setup
  camera = new THREE.PerspectiveCamera(fov, aspect, near, far);
  camera.position.set(10, -3, 350);

  //lighting
  const ambient = new THREE.AmbientLight(0x404040, 1);
  scene.add(ambient);

  const lighttop = new THREE.DirectionalLight(0xff5555, 4)
  lighttop.position.set(30,30,10);
  scene.add(lighttop);

  const lightbottom = new THREE.DirectionalLight(0x55ff55, 4)
  lightbottom.position.set(-30,-30,10);
  scene.add(lightbottom);

  //renderer
  renderer = new THREE.WebGLRenderer({antialias:true, alpha:true}); //alpha makes the background transparent;
  renderer.setSize(container.clientWidth, container.clientHeight);
  renderer.setPixelRatio(window.devicePixelRatio);

  container.appendChild(renderer.domElement); //inject the renderer into the 'scene' div

  //load models
  loader.load("/db/3d/model/scene.gltf", function(gltf){
    scene.add(gltf.scene);
    model = gltf.scene.children[0]; //get the loaded model and put it into 'model'
    model.position.z = -765;
    animate();
  });

//animation function
function animate(){
  requestAnimationFrame(animate);
  if (rotation > 6.25 || rotation < -6.25) {
    rotation = 0;
  } else {
    rotation += 0.05;
  }

  model.rotation.z = rotation;
  renderer.render(scene,camera); // render the image
}
}
init();

//on window resize function
function onWindowResize() {
  camera.aspect = container.clientWidth / container.clientHeight;
  camera.updateProjectionMatrix();

  renderer.setSize(container.clientWidth, container.clientHeight);
}

window.addEventListener("resize", onWindowResize);
