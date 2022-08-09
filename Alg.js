let automorphic = [];
let countOfAutomorphic = 0;
const input = 7;
let automorphicing = (k)=>
{
    let tempOfK= k ;
    let square = k*k;
    if(k == 0)
        return tempOfK;
    while(k > 0)
    {
        if( (k % 10) != (square%10) )
            return -1;
        k = Math.floor(k / 10);
        square = Math.floor(square / 10);
    }
    return tempOfK;

};
let i=0;
while(countOfAutomorphic < input){

    let c = automorphicing(i);

    if(c>-1) {
        automorphic[countOfAutomorphic] = c;
        countOfAutomorphic++;
    }

    i++;



}
console.log(automorphic);
console.log(countOfAutomorphic);
