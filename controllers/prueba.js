var myArray = [1,3,4,2,7,0];

for (let i = 0; i < numbers.length; i += 1) {
    for (let j = 0; j < numbers.length; j += 1) {
        // evitamos la comparación de un elemento consigo mismo
        if (i != j && (numbers[i] + numbers[j]) == 10) {
            return true;
        }
    }
}