function checkLocalizationNear() {
    if (navigator.geolocation) {
        // Solicitar permissão para acessar a localização
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const userLatitude = position.coords.latitude;
                const userLongitude = position.coords.longitude;
                console.log(`Latitude: ${userLatitude}, Longitude: ${userLongitude}`);

                // Chamar a função para calcular e ordenar as distâncias
                const lojasOrdenadas = ordenarLojasPorDistancia(userLatitude, userLongitude, listaDeLojas);
                console.log("Lojas ordenadas por distância:", lojasOrdenadas);
                alert("Lojas mais próximas: \n" + lojasOrdenadas.map(loja =>
                    `${loja.nome} - ${loja.endereco} (${loja.distancia.toFixed(2)} km)`
                ).join("\n"));
            },
            (error) => {
                console.error("Erro ao obter a localização:", error.message);
                alert("Não foi possível acessar a sua localização. Verifique suas configurações de permissão.");
            }
        );
    } else {
        alert("Seu navegador não suporta geolocalização.");
    }
}

function calcularDistancia(lat1, lon1, lat2, lon2) {
    const R = 6371; // Raio da Terra em km
    const dLat = ((lat2 - lat1) * Math.PI) / 180;
    const dLon = ((lon2 - lon1) * Math.PI) / 180;
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos((lat1 * Math.PI) / 180) *
        Math.cos((lat2 * Math.PI) / 180) *
        Math.sin(dLon / 2) *
        Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c; // Distância em km
}

function ordenarLojasPorDistancia(userLat, userLon, lojas) {
    // Calcular a distância de cada loja e adicionar ao objeto
    const lojasComDistancia = lojas.map(loja => {
        const distancia = calcularDistancia(userLat, userLon, loja.latitude, loja.longitude);
        return { ...loja, distancia };
    });

    // Ordenar as lojas pela distância (menor para maior)
    return lojasComDistancia.sort((a, b) => a.distancia - b.distancia);
}

const listaDeLojas = [
    {
        "nome": "Loja Ariston",
        "latitude": -23.5292,
        "longitude": -46.8451,
        "endereco": "Ariston, Carapicuíba - SP, Brasil"
    },
    {
        "nome": "Loja Carapicuiba",
        "latitude": -23.5235,
        "longitude": -46.835,
        "endereco": "Centro, Carapicuíba - SP, Brasil"
    },
    {
        "nome": "Loja Osasco",
        "latitude": -23.5329,
        "longitude": -46.7927,
        "endereco": "Centro, Osasco - SP, Brasil"
    },
    {
        "nome": "Loja Alphaville",
        "latitude": -23.5025,
        "longitude": -46.8461,
        "endereco": "Alphaville, Barueri - SP, Brasil"
    },
    {
        "nome": "Loja Barueri",
        "latitude": -23.5105,
        "longitude": -46.8764,
        "endereco": "Centro, Barueri - SP, Brasil"
    },
    {
        "nome": "Loja Tamboré",
        "latitude": -23.5043,
        "longitude": -46.8502,
        "endereco": "Tamboré, Barueri - SP, Brasil"
    },
    {
        "nome": "Loja Santana",
        "latitude": -23.5019,
        "longitude": -46.6248,
        "endereco": "Santana, São Paulo - SP, Brasil"
    },
    {
        "nome": "Loja Lapa",
        "latitude": -23.5277,
        "longitude": -46.7014,
        "endereco": "Lapa, São Paulo - SP, Brasil"
    },
    {
        "nome": "Loja Pinheiros",
        "latitude": -23.5611,
        "longitude": -46.7017,
        "endereco": "Pinheiros, São Paulo - SP, Brasil"
    },
    {
        "nome": "Loja Vila Mariana",
        "latitude": -23.5891,
        "longitude": -46.6341,
        "endereco": "Vila Mariana, São Paulo - SP, Brasil"
    },
    {
        "nome": "Loja Moema",
        "latitude": -23.6105,
        "longitude": -46.6561,
        "endereco": "Moema, São Paulo - SP, Brasil"
    },
    {
        "nome": "Loja Brooklin",
        "latitude": -23.6097,
        "longitude": -46.6968,
        "endereco": "Brooklin, São Paulo - SP, Brasil"
    },
    {
        "nome": "Loja Santo Amaro",
        "latitude": -23.6552,
        "longitude": -46.7115,
        "endereco": "Santo Amaro, São Paulo - SP, Brasil"
    },
    {
        "nome": "Loja Morumbi",
        "latitude": -23.6064,
        "longitude": -46.7228,
        "endereco": "Morumbi, São Paulo - SP, Brasil"
    },
    {
        "nome": "Loja Taboão da Serra",
        "latitude": -23.6264,
        "longitude": -46.7911,
        "endereco": "Taboão da Serra - SP, Brasil"
    },
    {
        "nome": "Loja Cotia",
        "latitude": -23.6022,
        "longitude": -46.9206,
        "endereco": "Cotia - SP, Brasil"
    },
    {
        "nome": "Loja Embu das Artes",
        "latitude": -23.6433,
        "longitude": -46.8525,
        "endereco": "Embu das Artes - SP, Brasil"
    },
    {
        "nome": "Loja Itapecerica",
        "latitude": -23.7161,
        "longitude": -46.8489,
        "endereco": "Itapecerica da Serra - SP, Brasil"
    },
    {
        "nome": "Loja Interlagos",
        "latitude": -23.7015,
        "longitude": -46.6876,
        "endereco": "Interlagos, São Paulo - SP, Brasil"
    },
    {
        "nome": "Loja Diadema",
        "latitude": -23.6866,
        "longitude": -46.6221,
        "endereco": "Centro, Diadema - SP, Brasil"
    },
    {
        "nome": "Loja São Bernardo",
        "latitude": -23.7143,
        "longitude": -46.5548,
        "endereco": "São Bernardo do Campo - SP, Brasil"
    },
    {
        "nome": "Loja Santo André",
        "latitude": -23.6633,
        "longitude": -46.5271,
        "endereco": "Centro, Santo André - SP, Brasil"
    },
    {
        "nome": "Loja Mauá",
        "latitude": -23.6688,
        "longitude": -46.4617,
        "endereco": "Mauá - SP, Brasil"
    }
];
