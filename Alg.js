let number = 1;
let autophormic = 0;
for(let i=0;i<=36;i++) {
    if (autophormic > number*number)
        break;
    let t =i*i;
    console.log(t);
    if (t % 10*(i.toString().length ) == i) {
        autophormic = i;


    }
}
console.log(autophormic);
