package com.labmobile.kulinerku.network;

import java.io.IOException;
import okhttp3.Interceptor;
import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Protocol;
import okhttp3.Request;
import okhttp3.Response;
import okhttp3.ResponseBody;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

// Singleton helper untuk inisialisasi dan akses Retrofit API client
public class ApiClient {
    private static final String BASE_URL = "https://www.themealdb.com/api/json/v1/1/";
    private static Retrofit retrofit = null;

    // Mendapatkan instance Retrofit ApiService secara singleton
    public static ApiService getApiService() {
        if (retrofit == null) {
            OkHttpClient client = new OkHttpClient.Builder()
                    .addInterceptor(new IndonesianFoodInterceptor())
                    .build();

            retrofit = new Retrofit.Builder()
                    .baseUrl(BASE_URL)
                    .client(client)
                    .addConverterFactory(GsonConverterFactory.create())
                    .build();
        }
        return retrofit.create(ApiService.class);
    }

    // Interceptor OkHttp untuk menyajikan data kuliner asli Indonesia secara lokal dengan gambar unik dari server TheMealDB
    private static class IndonesianFoodInterceptor implements Interceptor {
        @Override
        public Response intercept(Chain chain) throws IOException {
            Request request = chain.request();
            String url = request.url().toString();
            String jsonResponse = "";

            if (url.contains("categories.php")) {
                jsonResponse = getCategoriesJson();
            } else if (url.contains("filter.php")) {
                String category = request.url().queryParameter("c");
                jsonResponse = getMealsByCategoryJson(category);
            } else if (url.contains("search.php")) {
                String query = request.url().queryParameter("s");
                jsonResponse = getSearchMealsJson(query);
            } else if (url.contains("lookup.php")) {
                String id = request.url().queryParameter("i");
                jsonResponse = getMealDetailJson(id);
            } else {
                return chain.proceed(request);
            }

            return new Response.Builder()
                    .code(200)
                    .message("OK")
                    .request(request)
                    .protocol(Protocol.HTTP_1_1)
                    .body(ResponseBody.create(MediaType.parse("application/json"), jsonResponse))
                    .addHeader("content-type", "application/json")
                    .build();
        }
    }

    // Mengambil JSON daftar kategori makanan khas Indonesia dengan tombol "Semua" di awal
    private static String getCategoriesJson() {
        return "{\n" +
                "  \"categories\": [\n" +
                "    {\n" +
                "      \"idCategory\": \"0\",\n" +
                "      \"strCategory\": \"Semua\",\n" +
                "      \"strCategoryThumb\": \"https://www.themealdb.com/images/category/starter.png\",\n" +
                "      \"strCategoryDescription\": \"Seluruh daftar kuliner Nusantara terbaik.\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"idCategory\": \"1\",\n" +
                "      \"strCategory\": \"Daging\",\n" +
                "      \"strCategoryThumb\": \"https://www.themealdb.com/images/category/beef.png\",\n" +
                "      \"strCategoryDescription\": \"Olahan daging sapi dan kambing khas Nusantara dengan bumbu rempah melimpah.\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"idCategory\": \"2\",\n" +
                "      \"strCategory\": \"Ayam\",\n" +
                "      \"strCategoryThumb\": \"https://www.themealdb.com/images/category/chicken.png\",\n" +
                "      \"strCategoryDescription\": \"Hidangan ayam dan bebek tradisional pilihan seperti opor, soto, dan betutu.\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"idCategory\": \"3\",\n" +
                "      \"strCategory\": \"Seafood\",\n" +
                "      \"strCategoryThumb\": \"https://www.themealdb.com/images/category/seafood.png\",\n" +
                "      \"strCategoryDescription\": \"Olahan laut segar dan ikan tawar bakar, balado, hingga pempek.\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"idCategory\": \"4\",\n" +
                "      \"strCategory\": \"Mie & Sayur\",\n" +
                "      \"strCategoryThumb\": \"https://www.themealdb.com/images/category/pasta.png\",\n" +
                "      \"strCategoryDescription\": \"Hidangan mie goreng tradisional Jawa, bakso sapi, ketoprak, dan sayuran segar.\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"idCategory\": \"5\",\n" +
                "      \"strCategory\": \"Pencuci Mulut\",\n" +
                "      \"strCategoryThumb\": \"https://www.themealdb.com/images/category/dessert.png\",\n" +
                "      \"strCategoryDescription\": \"Kudapan manis tradisional seperti pisang goreng, martabak manis, klepon, dan es cendol.\"\n" +
                "    }\n" +
                "  ]\n" +
                "}";
    }

    // Mengambil JSON daftar makanan berdasarkan kategori (masing-masing 8 menu unik dengan gambar TheMealDB yang sesuai)
    private static String getMealsByCategoryJson(String category) {
        if (category == null) category = "";
        String meals = "";
        
        String dagingMeals = "    {\n" +
                "      \"strMeal\": \"Rendang Daging\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/bc8v651619789840.jpg\",\n" +
                "      \"idMeal\": \"10001\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Nasi Goreng Kampung\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/wuyd2h1765655837.jpg\",\n" +
                "      \"idMeal\": \"10002\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Rawon Surabaya\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/vtqxtu1511784197.jpg\",\n" +
                "      \"idMeal\": \"10014\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Sate Maranggi\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/8rfd4q1764112993.jpg\",\n" +
                "      \"idMeal\": \"10016\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Dendeng Balado\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/wsqqsw1515364068.jpg\",\n" +
                "      \"idMeal\": \"10013\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Gulai Kambing\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/lqampv1762325397.jpg\",\n" +
                "      \"idMeal\": \"10015\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Nasi Uduk Jakarta\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/er4d081765186828.jpg\",\n" +
                "      \"idMeal\": \"10031\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Tahu Tek Surabaya\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/t2b8bn1779737789.jpg\",\n" +
                "      \"idMeal\": \"10035\"\n" +
                "    }";

        String ayamMeals = "    {\n" +
                "      \"strMeal\": \"Sate Ayam Madura\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/3um6il1763794322.jpg\",\n" +
                "      \"idMeal\": \"10004\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Soto Ayam Lamongan\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/lx1kkj1593349302.jpg\",\n" +
                "      \"idMeal\": \"10006\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Opor Ayam Lebaran\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/sstssx1487349585.jpg\",\n" +
                "      \"idMeal\": \"10007\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Ayam Goreng Kalasan\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/40r49m1763197022.jpg\",\n" +
                "      \"idMeal\": \"10017\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Ayam Bakar Taliwang\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/nlxald1764112200.jpg\",\n" +
                "      \"idMeal\": \"10018\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Ayam Betutu Bali\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/d8bfyg1764117503.jpg\",\n" +
                "      \"idMeal\": \"10019\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Bubur Ayam Jakarta\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/1529446352.jpg\",\n" +
                "      \"idMeal\": \"10036\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Bebek Goreng Madura\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/hglsbl1614346998.jpg\",\n" +
                "      \"idMeal\": \"10038\"\n" +
                "    }";

        String seafoodMeals = "    {\n" +
                "      \"strMeal\": \"Ikan Bakar Kecap\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/uwxusv1487344500.jpg\",\n" +
                "      \"idMeal\": \"10008\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Udang Balado\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/bx07m71764792853.jpg\",\n" +
                "      \"idMeal\": \"10009\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Pepes Ikan Mas\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/diuub11782687570.jpg\",\n" +
                "      \"idMeal\": \"10020\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Cumi Goreng Tepung\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/yhi46r1763330279.jpg\",\n" +
                "      \"idMeal\": \"10021\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Kepiting Saus Padang\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/rprcc51782774240.jpg\",\n" +
                "      \"idMeal\": \"10022\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Pempek Palembang\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/a15wsa1614349126.jpg\",\n" +
                "      \"idMeal\": \"10023\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Pecel Lele\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/9q1ci41779735714.jpg\",\n" +
                "      \"idMeal\": \"10039\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Cah Kangkung Seafood\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/9nh4dl1766435484.jpg\",\n" +
                "      \"idMeal\": \"10024\"\n" +
                "    }";

        String mieSayurMeals = "    {\n" +
                "      \"strMeal\": \"Mie Goreng Jawa\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/xquakq1619787532.jpg\",\n" +
                "      \"idMeal\": \"10003\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Gado-Gado Siram\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/bqx8mc1782684286.jpg\",\n" +
                "      \"idMeal\": \"10005\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Sayur Asem Jakarta\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/60oc3k1699009846.jpg\",\n" +
                "      \"idMeal\": \"10025\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Capcay Kuah\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/4uje7l1763762276.jpg\",\n" +
                "      \"idMeal\": \"10026\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Bakso Sapi Solo\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/x26z3y1780155760.jpg\",\n" +
                "      \"idMeal\": \"10027\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Ketoprak Jakarta\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/6g3rso1763486069.jpg\",\n" +
                "      \"idMeal\": \"10028\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Tahu Gejrot Cirebon\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/j9nray1765657692.jpg\",\n" +
                "      \"idMeal\": \"10032\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Lontong Sayur\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/4k8nzy1763583384.jpg\",\n" +
                "      \"idMeal\": \"10037\"\n" +
                "    }";

        String dessertMeals = "    {\n" +
                "      \"strMeal\": \"Pisang Goreng Keju\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/ul2uy31764794321.jpg\",\n" +
                "      \"idMeal\": \"10010\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Martabak Manis\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/adxcbq1619787919.jpg\",\n" +
                "      \"idMeal\": \"10011\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Es Cendol\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/1xscby1764790242.jpg\",\n" +
                "      \"idMeal\": \"10012\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Klepon Pandan\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/6ut2og1619790195.jpg\",\n" +
                "      \"idMeal\": \"10029\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Kolak Pisang\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/5pmn0g1779813285.jpg\",\n" +
                "      \"idMeal\": \"10030\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Bubur Sumsum\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/dm8kee1779553541.jpg\",\n" +
                "      \"idMeal\": \"10033\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Lumpia Semarang\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/9r2xrg1763771238.jpg\",\n" +
                "      \"idMeal\": \"10034\"\n" +
                "    },\n" +
                "    {\n" +
                "      \"strMeal\": \"Serabi Solo\",\n" +
                "      \"strMealThumb\": \"https://www.themealdb.com/images/media/meals/vmz7gl1614350221.jpg\",\n" +
                "      \"idMeal\": \"10040\"\n" +
                "    }";

        if (category.equalsIgnoreCase("Semua")) {
            meals = dagingMeals + ",\n" + ayamMeals + ",\n" + seafoodMeals + ",\n" + mieSayurMeals + ",\n" + dessertMeals;
        } else if (category.equalsIgnoreCase("Daging")) {
            meals = dagingMeals;
        } else if (category.equalsIgnoreCase("Ayam")) {
            meals = ayamMeals;
        } else if (category.equalsIgnoreCase("Seafood")) {
            meals = seafoodMeals;
        } else if (category.equalsIgnoreCase("Mie & Sayur")) {
            meals = mieSayurMeals;
        } else if (category.equalsIgnoreCase("Pencuci Mulut")) {
            meals = dessertMeals;
        }

        return "{\n  \"meals\": [\n" + meals + "\n  ]\n}";
    }

    // Melakukan pencarian lokal case-insensitive terhadap seluruh 40 masakan Indonesia
    private static String getSearchMealsJson(String query) {
        if (query == null) query = "";
        query = query.toLowerCase().trim();

        // Seluruh 40 makanan dengan gambar unik TheMealDB yang sesuai
        String[][] allMeals = {
            {"Rendang Daging", "https://www.themealdb.com/images/media/meals/bc8v651619789840.jpg", "10001"},
            {"Nasi Goreng Kampung", "https://www.themealdb.com/images/media/meals/wuyd2h1765655837.jpg", "10002"},
            {"Mie Goreng Jawa", "https://www.themealdb.com/images/media/meals/xquakq1619787532.jpg", "10003"},
            {"Sate Ayam Madura", "https://www.themealdb.com/images/media/meals/3um6il1763794322.jpg", "10004"},
            {"Gado-Gado Siram", "https://www.themealdb.com/images/media/meals/bqx8mc1782684286.jpg", "10005"},
            {"Soto Ayam Lamongan", "https://www.themealdb.com/images/media/meals/lx1kkj1593349302.jpg", "10006"},
            {"Opor Ayam Lebaran", "https://www.themealdb.com/images/media/meals/sstssx1487349585.jpg", "10007"},
            {"Ikan Bakar Kecap", "https://www.themealdb.com/images/media/meals/uwxusv1487344500.jpg", "10008"},
            {"Udang Balado", "https://www.themealdb.com/images/media/meals/bx07m71764792853.jpg", "10009"},
            {"Pisang Goreng Keju", "https://www.themealdb.com/images/media/meals/ul2uy31764794321.jpg", "10010"},
            {"Martabak Manis", "https://www.themealdb.com/images/media/meals/adxcbq1619787919.jpg", "10011"},
            {"Es Cendol", "https://www.themealdb.com/images/media/meals/1xscby1764790242.jpg", "10012"},
            {"Dendeng Balado", "https://www.themealdb.com/images/media/meals/wsqqsw1515364068.jpg", "10013"},
            {"Rawon Surabaya", "https://www.themealdb.com/images/media/meals/vtqxtu1511784197.jpg", "10014"},
            {"Gulai Kambing", "https://www.themealdb.com/images/media/meals/lqampv1762325397.jpg", "10015"},
            {"Sate Maranggi", "https://www.themealdb.com/images/media/meals/8rfd4q1764112993.jpg", "10016"},
            {"Ayam Goreng Kalasan", "https://www.themealdb.com/images/media/meals/40r49m1763197022.jpg", "10017"},
            {"Ayam Bakar Taliwang", "https://www.themealdb.com/images/media/meals/nlxald1764112200.jpg", "10018"},
            {"Ayam Betutu Bali", "https://www.themealdb.com/images/media/meals/d8bfyg1764117503.jpg", "10019"},
            {"Pepes Ikan Mas", "https://www.themealdb.com/images/media/meals/diuub11782687570.jpg", "10020"},
            {"Cumi Goreng Tepung", "https://www.themealdb.com/images/media/meals/yhi46r1763330279.jpg", "10021"},
            {"Kepiting Saus Padang", "https://www.themealdb.com/images/media/meals/rprcc51782774240.jpg", "10022"},
            {"Pempek Palembang", "https://www.themealdb.com/images/media/meals/a15wsa1614349126.jpg", "10023"},
            {"Sayur Asem Jakarta", "https://www.themealdb.com/images/media/meals/60oc3k1699009846.jpg", "10025"},
            {"Capcay Kuah", "https://www.themealdb.com/images/media/meals/4uje7l1763762276.jpg", "10026"},
            {"Bakso Sapi Solo", "https://www.themealdb.com/images/media/meals/x26z3y1780155760.jpg", "10027"},
            {"Ketoprak Jakarta", "https://www.themealdb.com/images/media/meals/6g3rso1763486069.jpg", "10028"},
            {"Klepon Pandan", "https://www.themealdb.com/images/media/meals/6ut2og1619790195.jpg", "10029"},
            {"Kolak Pisang", "https://www.themealdb.com/images/media/meals/5pmn0g1779813285.jpg", "10030"},
            {"Bubur Sumsum", "https://www.themealdb.com/images/media/meals/dm8kee1779553541.jpg", "10033"},
            {"Nasi Uduk Jakarta", "https://www.themealdb.com/images/media/meals/er4d081765186828.jpg", "10031"},
            {"Tahu Gejrot Cirebon", "https://www.themealdb.com/images/media/meals/j9nray1765657692.jpg", "10032"},
            {"Lumpia Semarang", "https://www.themealdb.com/images/media/meals/9r2xrg1763771238.jpg", "10034"},
            {"Tahu Tek Surabaya", "https://www.themealdb.com/images/media/meals/t2b8bn1779737789.jpg", "10035"},
            {"Bubur Ayam Jakarta", "https://www.themealdb.com/images/media/meals/1529446352.jpg", "10036"},
            {"Lontong Sayur", "https://www.themealdb.com/images/media/meals/4k8nzy1763583384.jpg", "10037"},
            {"Bebek Goreng Madura", "https://www.themealdb.com/images/media/meals/hglsbl1614346998.jpg", "10038"},
            {"Pecel Lele", "https://www.themealdb.com/images/media/meals/9q1ci41779735714.jpg", "10039"},
            {"Serabi Solo", "https://www.themealdb.com/images/media/meals/vmz7gl1614350221.jpg", "10040"},
            {"Cah Kangkung Seafood", "https://www.themealdb.com/images/media/meals/9nh4dl1766435484.jpg", "10024"}
        };

        StringBuilder sb = new StringBuilder();
        boolean first = true;
        for (String[] meal : allMeals) {
            if (query.isEmpty() || meal[0].toLowerCase().contains(query)) {
                if (!first) {
                    sb.append(",\n");
                }
                sb.append("    {\n")
                  .append("      \"strMeal\": \"").append(meal[0]).append("\",\n")
                  .append("      \"strMealThumb\": \"").append(meal[1]).append("\",\n")
                  .append("      \"idMeal\": \"").append(meal[2]).append("\"\n")
                  .append("    }");
                first = false;
            }
        }

        if (sb.length() == 0) {
            return "{\"meals\": null}";
        }

        return "{\n  \"meals\": [\n" + sb.toString() + "\n  ]\n}";
    }

    // Mengambil detail resep masakan berdasarkan ID makanan
    private static String getMealDetailJson(String id) {
        if (id == null) id = "";

        String name = "";
        String category = "";
        String thumb = "";
        String instructions = "";
        String ingStr = "";

        if (id.equals("10001")) {
            name = "Rendang Daging";
            category = "Daging";
            thumb = "https://www.themealdb.com/images/media/meals/bc8v651619789840.jpg";
            instructions = "1. Potong daging sapi menjadi kotak-kotak kecil.\\n2. Haluskan bumbu halus (bawang merah, bawang putih, cabai, jahe, lengkuas, kunyit, ketumbar).\\n3. Tumis bumbu halus bersama serai, daun jeruk, daun kunyit, dan asam kandis hingga harum.\\n4. Masukkan daging sapi, aduk hingga berubah warna.\\n5. Tuang santan cair, masak dengan api sedang hingga mendidih.\\n6. Tambahkan santan kental, garam, dan kelapa sangrai.\\n7. Kecilkan api, masak terus sambil diaduk hingga kuah menyusut, mengeluarkan minyak, dan berwarna cokelat gelap.";
            ingStr = getIngredientsJson(new String[]{
                "Daging Sapi", "Santan Kental", "Santan Cair", "Bawang Merah", "Bawang Putih",
                "Cabai Merah", "Jahe", "Lengkuas", "Serai", "Daun Kunyit"
            }, new String[]{
                "500g", "500ml", "500ml", "10 butir", "6 siung",
                "100g", "2cm", "3cm", "2 batang", "1 lembar"
            });
        } else if (id.equals("10002")) {
            name = "Nasi Goreng Kampung";
            category = "Daging";
            thumb = "https://www.themealdb.com/images/media/meals/wuyd2h1765655837.jpg";
            instructions = "1. Haluskan bawang merah, bawang putih, cabai merah, dan terasi bakar.\\n2. Panaskan minyak, tumis bumbu halus hingga harum.\\n3. Masukkan telur, buat orak-arik.\\n4. Tambahkan suwiran ayam dan bakso sapi iris.\\n5. Masukkan nasi putih dingin, aduk rata.\\n6. Tambahkan kecap manis, garam, dan lada bubuk.\\n7. Masak dengan api besar sambil diaduk cepat hingga bumbu meresap sempurna.\\n8. Sajikan hangat dengan telur mata sapi, kerupuk, dan irisan timun.";
            ingStr = getIngredientsJson(new String[]{
                "Nasi Putih", "Telur Ayam", "Bawang Merah", "Bawang Putih", "Cabai Merah",
                "Terasi Bakar", "Kecap Manis", "Garam", "Lada Bubuk", "Ayam Suwir"
            }, new String[]{
                "2 piring", "2 butir", "4 butir", "2 siung", "2 buah",
                "1 sdt", "2 sdm", "1 sdt", "1/2 sdt", "50g"
            });
        } else if (id.equals("10003")) {
            name = "Mie Goreng Jawa";
            category = "Mie & Sayur";
            thumb = "https://www.themealdb.com/images/media/meals/xquakq1619787532.jpg";
            instructions = "1. Rebus mie basah atau mie telur hingga setengah matang, tiriskan dan lumuri sedikit minyak serta kecap manis.\\n2. Haluskan bawang merah, bawang putih, kemiri, dan lada. Tumis bumbu halus hingga wangi.\\n3. Masukkan bakso iris and daging ayam. Tambahkan kol dan sawi hijau.\\n4. Masukkan mie, aduk rata.\\n5. Bumbui dengan garam, kaldu bubuk, dan kecap manis tambahan.\\n6. Masak hingga sayuran layu dan bumbu meresap.\\n7. Taburi bawang goreng sebelum disajikan.";
            ingStr = getIngredientsJson(new String[]{
                "Mie Telur", "Daging Ayam", "Bakso Sapi", "Sawi Hijau", "Kol",
                "Bawang Merah", "Bawang Putih", "Kemiri", "Kecap Manis", "Lada Bubuk"
            }, new String[]{
                "200g", "50g", "5 butir", "1 ikat", "3 lembar",
                "5 butir", "3 siung", "2 butir", "3 sdm", "1/2 sdt"
            });
        } else if (id.equals("10004")) {
            name = "Sate Ayam Madura";
            category = "Ayam";
            thumb = "https://www.themealdb.com/images/media/meals/3um6il1763794322.jpg";
            instructions = "1. Potong dada ayam berbentuk dadu, lalu tusuk dengan tusuk sate.\\n2. Haluskan bahan bumbu kacang (kacang tanah goreng, kemiri, bawang merah, bawang putih, cabai, gula merah, garam).\\n3. Tumis bumbu kacang hingga mengeluarkan minyak.\\n4. Ambil sedikit bumbu kacang, campurkan dengan kecap manis and sedikit minyak untuk bumbu olesan.\\n5. Olesi sate dengan bumbu olesan, lalu bakar di atas bara api hingga matang kecokelatan.\\n6. Sajikan sate dengan siraman bumbu kacang sisa, irisan bawang merah, cabai rawit, dan kecap manis.";
            ingStr = getIngredientsJson(new String[]{
                "Dada Ayam", "Kacang Tanah", "Bawang Merah", "Bawang Putih", "Kemiri",
                "Gula Merah", "Kecap Manis", "Cabai Merah", "Garam", "Minyak Goreng"
            }, new String[]{
                "500g", "150g", "6 butir", "3 siung", "3 butir",
                "50g", "5 sdm", "3 buah", "1 sdt", "2 sdm"
            });
        } else if (id.equals("10005")) {
            name = "Gado-Gado Siram";
            category = "Mie & Sayur";
            thumb = "https://www.themealdb.com/images/media/meals/bqx8mc1782684286.jpg";
            instructions = "1. Rebus semua sayuran (kangkung, tauge, kacang panjang, kol) hingga matang, tiriskan.\\n2. Potong-potong tahu dan tempe goreng serta kentang rebus.\\n3. Haluskan kacang tanah goreng bersama cabai, bawang putih, air asam jawa, kencur, gula merah, dan garam.\\n4. Tuangkan air hangat sedikit demi sedikit hingga saus kacang mengental pas.\\n5. Tata sayuran rebus, tahu, tempe, kentang, dan irisan telur rebus di piring.\\n6. Siram dengan bumbu kacang kental.\\n7. Sajikan dengan taburan kerupuk udang dan emping.";
            ingStr = getIngredientsJson(new String[]{
                "Kangkung", "Tauge", "Kacang Panjang", "Kol", "Tahu Goreng",
                "Tempe Goreng", "Kentang Rebus", "Telur Rebus", "Kacang Tanah", "Gula Merah"
            }, new String[]{
                "1 ikat", "100g", "5 batang", "3 lembar", "2 buah",
                "2 buah", "1 buah", "1 buah", "100g", "30g"
            });
        } else if (id.equals("10006")) {
            name = "Soto Ayam Lamongan";
            category = "Ayam";
            thumb = "https://www.themealdb.com/images/media/meals/lx1kkj1593349302.jpg";
            instructions = "1. Rebus ayam bersama serai, daun jeruk, dan lengkuas.\\n2. Haluskan bumbu (bawang merah, bawang putih, kemiri, kunyit bakar, jahe, ketumbar, merica).\\n3. Tumis bumbu halus hingga harum, lalu masukkan ke dalam air rebusan ayam.\\n4. Masak hingga ayam matang and empuk. Angkat ayam, suwir-suwir dagingnya.\\n5. Masukkan irisan kol, tauge, soun, dan suwiran ayam ke mangkuk.\\n6. Tuangkan kuah soto panas.\\n7. Sajikan dengan taburan seledri, bawang goreng, koya kerupuk udang, telur rebus, dan perasan jeruk nipis.";
            ingStr = getIngredientsJson(new String[]{
                "Daging Ayam", "Kol Iris", "Tauge", "Soun", "Serai",
                "Daun Jeruk", "Bawang Merah", "Bawang Putih", "Kunyit Bakar", "Koya"
            }, new String[]{
                "1/2 ekor", "100g", "50g", "50g", "2 batang",
                "4 lembar", "6 butir", "4 siung", "2cm", "2 sdm"
            });
        } else if (id.equals("10007")) {
            name = "Opor Ayam Lebaran";
            category = "Ayam";
            thumb = "https://www.themealdb.com/images/media/meals/sstssx1487349585.jpg";
            instructions = "1. Potong ayam menjadi beberapa bagian.\\n2. Haluskan bawang merah, bawang putih, ketumbar, jintan, merica, jahe, dan kunyit.\\n3. Tumis bumbu halus bersama serai, daun salam, dan lengkuas memar hingga wangi.\\n4. Masukkan ayam, aduk hingga ayam berubah warna.\\n5. Tuang santan encer, masa hingga mendidih dan daging ayam empuk.\\n6. Tambahkan santan kental, garam, dan gula pasir.\\n7. Masak sambil terus diaduk perlahan di atas api kecil hingga kuah sedikit menyusut dan mengental gurih.\\n8. Sajikan dengan lontong dan taburan bawang goreng.";
            ingStr = getIngredientsJson(new String[]{
                "Daging Ayam", "Santan Encer", "Santan Kental", "Bawang Merah", "Bawang Putih",
                "Ketumbar", "Serai", "Daun Salam", "Lengkuas", "Garam"
            }, new String[]{
                "1/2 ekor", "400ml", "200ml", "8 butir", "4 siung",
                "1 sdt", "1 batang", "2 lembar", "2cm", "1.5 sdt"
            });
        } else if (id.equals("10008")) {
            name = "Ikan Bakar Kecap";
            category = "Seafood";
            thumb = "https://www.themealdb.com/images/media/meals/uwxusv1487344500.jpg";
            instructions = "1. Bersihkan ikan mas atau nila, lumuri dengan air perasan jeruk nipis dan garam, diamkan 15 menit.\\n2. Haluskan bawang merah, bawang putih, cabai, ketumbar, dan jahe.\\n3. Tumis bumbu halus hingga wangi, campurkan dengan kecap manis dan mentega cair untuk bahan olesan.\\n4. Lumuri ikan dengan bumbu olesan hingga rata.\\n5. Bakar ikan di atas alat pemanggang sambil sesekali diolesi bumbu olesan hingga kedua sisi ikan matang merata.\\n6. Sajikan dengan sambal kecap irisan bawang dan tomat.";
            ingStr = getIngredientsJson(new String[]{
                "Ikan Nila/Mas", "Jeruk Nipis", "Bawang Merah", "Bawang Putih", "Cabai Merah",
                "Ketumbar", "Kecap Manis", "Mentega", "Garam", "Lada"
            }, new String[]{
                "1 ekor", "1 buah", "5 butir", "3 siung", "2 buah",
                "1 sdt", "5 sdm", "1 sdm", "1 sdt", "1/2 sdt"
            });
        } else if (id.equals("10009")) {
            name = "Udang Balado";
            category = "Seafood";
            thumb = "https://www.themealdb.com/images/media/meals/bx07m71764792853.jpg";
            instructions = "1. Bersihkan udang dari kepala dan kulitnya, sisakan ekor.\\n2. Haluskan bawang merah, bawang putih, cabai merah keriting, cabai rawit, dan tomat merah.\\n3. Tumis bumbu halus bersama daun jeruk purut hingga harum dan matang.\\n4. Masukkan udang yang telah dibersihkan.\\n5. Tambahkan garam, gula pasir, dan sedikit kaldu bubuk.\\n6. Aduk rata dan masak udang dengan api sedang-besar hingga udang berubah warna menjadi kemerahan.\\n7. Angkat dan sajikan hangat.";
            ingStr = getIngredientsJson(new String[]{
                "Udang Segar", "Cabai Merah", "Bawang Merah", "Bawang Putih", "Tomat Merah",
                "Daun Jeruk", "Garam", "Gula Pasir", "Kaldu Bubuk", "Minyak Goreng"
            }, new String[]{
                "300g", "8 buah", "6 butir", "3 siung", "1 buah",
                "2 lembar", "1 sdt", "1/2 sdt", "1/2 sdt", "2 sdm"
            });
        } else if (id.equals("10010")) {
            name = "Pisang Goreng Keju";
            category = "Pencuci Mulut";
            thumb = "https://www.themealdb.com/images/media/meals/ul2uy31764794321.jpg";
            instructions = "1. Kupas pisang kepok atau pisang raja, potong memanjang membentuk kipas.\\n2. Campurkan tepung terigu, tepung beras, sedikit gula, garam, dan air hangat hingga membentuk adonan pencelup yang kental.\\n3. Celupkan pisang ke dalam adonan tepung, lalu goreng dalam minyak panas hingga kuning keemasan.\\n4. Angkat dan tiriskan.\\n5. Selagi panas, tata pisang di atas piring, beri kucuran susu kental manis, lalu taburi parutan keju cheddar melimpah.";
            ingStr = getIngredientsJson(new String[]{
                "Pisang Kepok", "Tepung Terigu", "Tepung Beras", "Gula Pasir", "Garam",
                "Keju Cheddar", "Susu Kental Manis", "Minyak Goreng", "Air", "Vanili"
            }, new String[]{
                "6 buah", "100g", "2 sdm", "1 sdm", "1/2 sdt",
                "50g", "secukupnya", "secukupnya", "secukupnya", "150ml", "sejumput"
            });
        } else if (id.equals("10011")) {
            name = "Martabak Manis";
            category = "Pencuci Mulut";
            thumb = "https://www.themealdb.com/images/media/meals/adxcbq1619787919.jpg";
            instructions = "1. Kocok tepung terigu, gula pasir, telur, air, dan sedikit garam hingga adonan lembut tidak bergerindil.\\n2. Diamkan adonan selama 1 jam.\\n3. Masukkan baking powder dan baking soda sesaat sebelum dimasak, aduk rata.\\n4. Tuang adonan ke dalam wajan teflon martabak yang sudah panas.\\n5. Biarkan hingga bersarang/berongga di permukaannya, taburi gula pasir, lalu tutup wajan dan kecilkan api hingga matang.\\n6. Angkat, olesi mentega melimpah, beri taburan cokelat meises, kacang sangrai, dan susu kental manis.\\n7. Lipat martabak, potong-potong.";
            ingStr = getIngredientsJson(new String[]{
                "Tepung Terigu", "Gula Pasir", "Telur Ayam", "Air", "Baking Powder",
                "Baking Soda", "Mentega", "Cokelat Meises", "Kacang Tanah", "Susu Kental Manis"
            }, new String[]{
                "250g", "3 sdm", "1 butir", "300ml", "1/2 sdt",
                "1/2 sdt", "secukupnya", "secukupnya", "secukupnya", "secukupnya"
            });
        } else if (id.equals("10012")) {
            name = "Es Cendol";
            category = "Pencuci Mulut";
            thumb = "https://www.themealdb.com/images/media/meals/1xscby1764790242.jpg";
            instructions = "1. Larutkan gula merah bersama air dan daun pandan hingga mendidih dan mengental menjadi sirup gula merah.\\n2. Rebus santan bersama sedikit garam dan daun pandan hingga matang, dinginkan.\\n3. Tata cendol hijau di bagian bawah gelas saji. Tambahkan potongan buah nangka.\\n4. Beri es serut atau es batu secukupnya.\\n5. Tuangkan kuah santan gurih, lalu siramkan sirup gula merah pekat di atasnya.\\n6. Aduk rata sebelum dinikmati dingin.";
            ingStr = getIngredientsJson(new String[]{
                "Cendol Hijau", "Santan Kelapa", "Gula Merah", "Daun Pandan", "Garam",
                "Buah Nangka", "Es Batu", "Air", "Gula Pasir", "Susu"
            }, new String[]{
                "150g", "300ml", "150g", "2 lembar", "1/4 sdt",
                "3 buah", "secukupnya", "100ml", "1 sdm", "secukupnya"
            });
        } else if (id.equals("10013")) {
            name = "Dendeng Balado";
            category = "Daging";
            thumb = "https://www.themealdb.com/images/media/meals/wsqqsw1515364068.jpg";
            instructions = "1. Iris tipis daging sapi searah serat.\\n2. Rebus daging dengan bawang putih geprek, ketumbar, dan garam hingga empuk. Angkat dan memarkan daging hingga tipis.\\n3. Goreng daging dalam minyak panas sebentar hingga renyah, tiriskan.\\n4. Tumbuk kasar cabai merah, bawang merah, dan tomat.\\n5. Tumis bumbu kasar dengan sedikit air perasan jeruk nipis dan garam hingga matang.\\n6. Siram bumbu balado di atas dendeng goreng renyah.";
            ingStr = getIngredientsJson(new String[]{
                "Daging Sapi", "Bawang Merah", "Bawang Putih", "Cabai Merah", "Tomat Merah",
                "Jeruk Nipis", "Minyak Goreng", "Garam"
            }, new String[]{
                "500g", "8 butir", "4 siung", "100g", "1 buah",
                "1 buah", "secukupnya", "1 sdt"
            });
        } else if (id.equals("10014")) {
            name = "Rawon Surabaya";
            category = "Daging";
            thumb = "https://www.themealdb.com/images/media/meals/vtqxtu1511784197.jpg";
            instructions = "1. Rebus daging sapi hingga setengah empuk, potong dadu. Saring kaldunya.\\n2. Sangrai kluwek yang sudah diambil isinya, haluskan bersama bawang merah, bawang putih, kemiri, ketumbar, kunyit, dan jahe.\\n3. Tumis bumbu halus bersama serai, daun jeruk, dan lengkuas hingga harum.\\n4. Masukkan bumbu tumis ke dalam air kaldu daging. Masukkan daging sapi dadu.\\n5. Masak dengan api kecil hingga daging sangat empuk dan kuah kluwek hitam meresap.\\n6. Sajikan dengan tauge pendek, telur asin, jeruk nipis, sambal terasi, dan emping.";
            ingStr = getIngredientsJson(new String[]{
                "Daging Sapi", "Kluwek", "Bawang Merah", "Bawang Putih", "Kemiri",
                "Kunyit", "Jahe", "Daun Jeruk", "Serai", "Telur Asin"
            }, new String[]{
                "500g", "5 buah", "8 butir", "5 siung", "4 butir",
                "2cm", "2cm", "4 lembar", "2 batang", "2 buah"
            });
        } else if (id.equals("10015")) {
            name = "Gulai Kambing";
            category = "Daging";
            thumb = "https://www.themealdb.com/images/media/meals/lqampv1762325397.jpg";
            instructions = "1. Potong-potong daging dan jeroan kambing.\\n2. Haluskan bawang merah, bawang putih, cabai, kemiri, kunyit, jahe, ketumbar, pala, dan jintan.\\n3. Tumis bumbu halus bersama serai, cengkih, kayu manis, kapulaga, dan pekak hingga harum.\\n4. Masukkan daging kambing, aduk hingga kaku dan berubah warna.\\n5. Tuang santan encer, masak hingga daging empuk.\\n6. Tambahkan santan kental, garam, dan gula merah. Masak terus di atas api kecil sambil diaduk perlahan hingga bumbu meresap gurih.";
            ingStr = getIngredientsJson(new String[]{
                "Daging Kambing", "Santan Encer", "Santan Kental", "Bawang Merah", "Bawang Putih",
                "Cabai Merah", "Kunyit", "Kayu Manis", "Kapulaga", "Gula Merah"
            }, new String[]{
                "500g", "600ml", "200ml", "10 butir", "6 siung",
                "5 buah", "2cm", "3cm", "3 butir", "1 sdm"
            });
        } else if (id.equals("10016")) {
            name = "Sate Maranggi";
            category = "Daging";
            thumb = "https://www.themealdb.com/images/media/meals/8rfd4q1764112993.jpg";
            instructions = "1. Potong daging sapi berbentuk dadu kecil.\\n2. Haluskan ketumbar sangrai, bawang merah, bawang putih, lengkuas, air asam jawa, dan gula merah.\\n3. Lumuri daging dengan bumbu halus dan tambahkan sedikit kecap manis. Diamkan selama 1 jam.\\n4. Tusuk daging sapi pada tusuk sate.\\n5. Bakar sate di atas bara api sambil diolesi sisa bumbu olesan dan kecap manis hingga matang.\\n6. Sajikan hangat dengan sambal tomat iris mentah dan kecap manis.";
            ingStr = getIngredientsJson(new String[]{
                "Daging Sapi", "Bawang Merah", "Bawang Putih", "Ketumbar", "Gula Merah",
                "Air Asam Jawa", "Kecap Manis", "Tomat Merah", "Cabai Rawit", "Tusuk Sate"
            }, new String[]{
                "500g", "8 butir", "4 siung", "2 sdm", "50g",
                "2 sdm", "5 sdm", "2 buah", "10 buah", "secukupnya"
            });
        } else if (id.equals("10017")) {
            name = "Ayam Goreng Kalasan";
            category = "Ayam";
            thumb = "https://www.themealdb.com/images/media/meals/40r49m1763197022.jpg";
            instructions = "1. Bersihkan ayam, belah menjadi dua bagian.\\n2. Rebus ayam di dalam air kelapa bersama bawang putih halus, ketumbar, daun salam, lengkuas, gula merah, dan garam.\\n3. Masak dengan api sedang hingga air kelapa menyusut habis dan bumbu meresap. Angkat.\\n4. Panaskan minyak goreng yang cukup banyak.\\n5. Goreng ayam dalam minyak panas hingga berwarna cokelat keemasan sebentar saja. Angkat.\\n6. Sajikan ayam goreng gurih manis ini dengan kremesan renyah.";
            ingStr = getIngredientsJson(new String[]{
                "Ayam Utuh", "Air Kelapa", "Bawang Putih", "Gula Merah", "Ketumbar",
                "Daun Salam", "Lengkuas", "Garam", "Minyak Goreng", "Bawang Merah"
            }, new String[]{
                "1 ekor", "1 liter", "6 siung", "50g", "1 sdm",
                "3 lembar", "3cm", "1.5 sdt", "secukupnya", "4 butir"
            });
        } else if (id.equals("10018")) {
            name = "Ayam Bakar Taliwang";
            category = "Ayam";
            thumb = "https://www.themealdb.com/images/media/meals/nlxald1764112200.jpg";
            instructions = "1. Belah dada ayam kampung memanjang tengah, lebarkan.\\n2. Haluskan bawang merah, bawang putih, cabai merah, cabai rawit, kencur, terasi bakar, dan tomat.\\n3. Tumis bumbu halus hingga matang dan harum.\\n4. Lumuri ayam dengan bumbu tumis hingga rata. Diamkan 30 menit.\\n5. Panggang ayam di atas bara api sambil sesekali diolesi bumbu hingga matang kecokelatan beraroma bakar.\\n6. Sajikan ayam taliwang pedas gurih ini dengan plecing kangkung.";
            ingStr = getIngredientsJson(new String[]{
                "Ayam Kampung", "Bawang Merah", "Bawang Putih", "Cabai Merah", "Kencur",
                "Terasi Bakar", "Tomat", "Garam", "Gula Pasir", "Minyak Goreng"
            }, new String[]{
                "1 ekor", "8 butir", "4 siung", "6 buah", "3cm",
                "1 sdt", "1 buah", "1 sdt", "1/2 sdt", "2 sdm"
            });
        } else if (id.equals("10019")) {
            name = "Ayam Betutu Bali";
            category = "Ayam";
            thumb = "https://www.themealdb.com/images/media/meals/d8bfyg1764117503.jpg";
            instructions = "1. Bersihkan ayam utuh.\\n2. Haluskan bumbu base genep (bawang merah, bawang putih, cabai rawit, kencur, jahe, lengkuas, kunyit, kemiri, terasi, serai, daun jeruk, garam, ketumbar).\\n3. Lumuri ayam bagian luar dan dalam dengan bumbu base genep yang melimpah.\\n4. Bungkus ayam dengan daun pisang rapat-rapat.\\n5. Kukus ayam selama 1 jam hingga empuk, lalu panggang sebentar di oven atau bara api bersama bungkusnya. Sajikan.";
            ingStr = getIngredientsJson(new String[]{
                "Ayam Utuh", "Bawang Merah", "Bawang Putih", "Cabai Rawit", "Kunyit",
                "Kencur", "Jahe", "Lengkuas", "Serai", "Daun Pisang"
            }, new String[]{
                "1 ekor", "12 butir", "6 siung", "10 buah", "3cm",
                "3cm", "3cm", "3cm", "3 batang", "secukupnya"
            });
        } else if (id.equals("10020")) {
            name = "Pepes Ikan Mas";
            category = "Seafood";
            thumb = "https://www.themealdb.com/images/media/meals/diuub11782687570.jpg";
            instructions = "1. Bersihkan ikan mas, kerat-kerat badannya.\\n2. Haluskan bawang merah, bawang putih, kemiri, kunyit, jahe, cabai merah, dan garam.\\n3. Lumuri ikan dengan bumbu halus. Tambahkan daun kemangi, daun salam, serai iris, dan tomat.\\n4. Tata ikan beserta bumbu di atas daun pisang, bungkus rapat.\\n5. Kukus pepes ikan selama 45 menit hingga matang.\\n6. Panggang pepes di atas teflon sebentar hingga daun pisang mengering dan harum. Sajikan.";
            ingStr = getIngredientsJson(new String[]{
                "Ikan Mas", "Bawang Merah", "Bawang Putih", "Kemiri", "Kunyit",
                "Daun Kemangi", "Daun Salam", "Serai", "Daun Pisang", "Tomat"
            }, new String[]{
                "2 ekor", "6 butir", "4 siung", "4 butir", "3cm",
                "1 ikat", "4 lembar", "2 batang", "secukupnya", "1 buah"
            });
        } else if (id.equals("10021")) {
            name = "Cumi Goreng Tepung";
            category = "Seafood";
            thumb = "https://www.themealdb.com/images/media/meals/yhi46r1763330279.jpg";
            instructions = "1. Bersihkan cumi-cumi, potong melintang berbentuk cincin. Lumuri air jeruk nipis.\\n2. Campur tepung terigu, tepung maizena, bawang putih bubuk, merica, dan garam sebagai adonan tepung kering.\\n3. Ambil sebagian adonan tepung, campur dengan sedikit air es untuk adonan basah.\\n4. Celupkan cumi ke adonan basah, lalu gulingkan ke adonan kering.\\n5. Goreng cumi dalam minyak panas banyak hingga kuning keemasan garing renyah. Angkat.";
            ingStr = getIngredientsJson(new String[]{
                "Cumi-cumi", "Tepung Terigu", "Tepung Maizena", "Bawang Putih", "Merica Bubuk",
                "Jeruk Nipis", "Air Es", "Garam", "Minyak Goreng", "Lada"
            }, new String[]{
                "300g", "150g", "2 sdm", "1 sdt", "1/2 sdt",
                "1 buah", "secukupnya", "1 sdt", "secukupnya", "1/2 sdt"
            });
        } else if (id.equals("10022")) {
            name = "Kepiting Saus Padang";
            category = "Seafood";
            thumb = "https://www.themealdb.com/images/media/meals/rprcc51782774240.jpg";
            instructions = "1. Rebus kepiting hingga berubah warna kemerahan, belah badannya.\\n2. Haluskan bawang merah, bawang putih, cabai merah keriting, jahe, dan kunyit.\\n3. Tumis bumbu halus bersama bawang bombay cincang, daun jeruk, dan serai.\\n4. Tambahkan saus tiram, saus tomat, saus sambal, garam, lada, dan sedikit air.\\n5. Masukkan kepiting rebus, aduk hingga terbalur bumbu.\\n6. Masukkan kocokan telur ayam, aduk cepat hingga berserabut dan kuah mengental matang. Sajikan.";
            ingStr = getIngredientsJson(new String[]{
                "Kepiting", "Bawang Bombay", "Bawang Merah", "Bawang Putih", "Cabai Merah",
                "Saus Tiram", "Saus Sambal", "Telur Ayam", "Serai", "Jahe"
            }, new String[]{
                "2 ekor", "1/2 buah", "6 butir", "4 siung", "8 buah",
                "2 sdm", "4 sdm", "1 butir", "1 batang", "2cm"
            });
        } else if (id.equals("10023")) {
            name = "Pempek Palembang";
            category = "Seafood";
            thumb = "https://www.themealdb.com/images/media/meals/a15wsa1614349126.jpg";
            instructions = "1. Haluskan daging ikan tenggiri dingin.\\n2. Campur daging ikan dengan air es, garam, dan penyedap rasa hingga lengket.\\n3. Masukkan tepung sagu tani sedikit demi sedikit, aduk perlahan (jangan diuleni keras).\\n4. Bentuk adonan menjadi lenjer atau isi telur (kapal selam).\\n5. Rebus pempek di air mendidih hingga mengapung matang, tiriskan.\\n6. Goreng pempek dalam minyak panas hingga berkulit garing. Sajikan dengan saus cuko.";
            ingStr = getIngredientsJson(new String[]{
                "Ikan Tenggiri", "Tepung Sagu", "Air Es", "Garam", "Telur Ayam",
                "Gula Merah", "Cabai Rawit", "Bawang Putih", "Asam Jawa", "Air Cuko"
            }, new String[]{
                "500g", "350g", "250ml", "1.5 sdm", "2 butir",
                "250g", "10 buah", "5 siung", "secukupnya", "150ml"
            });
        } else if (id.equals("10024")) {
            name = "Cah Kangkung Seafood";
            category = "Seafood";
            thumb = "https://www.themealdb.com/images/media/meals/9nh4dl1766435484.jpg";
            instructions = "1. Petik kangkung segar, cuci bersih.\\n2. Iris bawang merah, bawang putih, cabai merah, dan tomat.\\n3. Tumis bumbu iris bersama terasi matang hingga wangi.\\n4. Masukkan udang kupas dan bakso ikan iris. Aduk hingga matang.\\n5. Masukkan kangkung, besarkan api.\\n6. Tambahkan saus tiram, garam, dan sedikit air.\\n7. Masak cepat agar kangkung tetap hijau segar renyah. Angkat.";
            ingStr = getIngredientsJson(new String[]{
                "Kangkung", "Udang", "Bakso Ikan", "Bawang Merah", "Bawang Putih",
                "Cabai Merah", "Terasi", "Saus Tiram", "Garam", "Minyak"
            }, new String[]{
                "2 ikat", "50g", "4 butir", "4 butir", "2 siung",
                "2 buah", "1/2 sdt", "1 sdm", "1/2 sdt", "secukupnya"
            });
        } else if (id.equals("10025")) {
            name = "Sayur Asem Jakarta";
            category = "Mie & Sayur";
            thumb = "https://www.themealdb.com/images/media/meals/60oc3k1699009846.jpg";
            instructions = "1. Potong-potong nangka muda, jagung manis, kacang panjang, labu siam, dan melinjo.\\n2. Rebus air, masukkan nangka muda, melinjo, dan jagung hingga empuk.\\n3. Haluskan bawang merah, bawang putih, cabai merah, kemiri, dan terasi.\\n4. Masukkan bumbu halus, daun salam, lengkuas, dan asam jawa ke dalam rebusan.\\n5. Masukkan kacang panjang, daun melinjo, dan labu siam. Tambahkan garam dan gula.\\n6. Masak hingga sayuran matang segar.";
            ingStr = getIngredientsJson(new String[]{
                "Nangka Muda", "Jagung Manis", "Kacang Panjang", "Labu Siam", "Daun Melinjo",
                "Asam Jawa", "Bawang Merah", "Bawang Putih", "Kemiri", "Terasi"
            }, new String[]{
                "100g", "1 buah", "5 batang", "1 buah", "50g",
                "3 buah", "5 butir", "3 siung", "3 butir", "1 sdt"
            });
        } else if (id.equals("10026")) {
            name = "Capcay Kuah";
            category = "Mie & Sayur";
            thumb = "https://www.themealdb.com/images/media/meals/4juje7l1763762276.jpg";
            instructions = "1. Potong-potong sayuran (wortel, kembang kol, sawi putih, sawi hijau, brokoli).\\n2. Tumis bawang putih cincang dan bawang bombay hingga wangi.\\n3. Masukkan irisan daging ayam dan bakso. Aduk hingga berubah warna.\\n4. Masukkan sayuran wortel dan brokoli, beri sedikit air.\\n5. Masukkan sawi dan kol. Bumbui dengan saus tiram, kecap asin, garam, lada, dan kaldu.\\n6. Tuang larutan maizena untuk mengentalkan kuah capcay, masak hingga matang.";
            ingStr = getIngredientsJson(new String[]{
                "Wortel", "Kembang Kol", "Sawi Putih", "Bakso Sapi", "Bawang Putih",
                "Bawang Bombay", "Saus Tiram", "Kecap Asin", "Tepung Maizena", "Brokoli"
            }, new String[]{
                "1 buah", "100g", "4 lembar", "5 butir", "3 siung",
                "1/2 buah", "1.5 sdm", "1 sdm", "1 sdt", "50g"
            });
        } else if (id.equals("10027")) {
            name = "Bakso Sapi Solo";
            category = "Mie & Sayur";
            thumb = "https://www.themealdb.com/images/media/meals/x26z3y1780155760.jpg";
            instructions = "1. Siapkan pentol bakso sapi Solo.\\n2. Rebus tulang sapi untuk kaldu bersama bawang putih goreng haluskan, pala, lada, garam, dan daun seledri.\\n3. Masak kuah kaldu di api kecil hingga kaldunya pekat gurih berkaldu.\\n4. Masukkan pentol bakso sapi ke dalam kuah kaldu panas hingga mengapung.\\n5. Tata mie kuning, soun, kol iris, dan seledri di mangkuk saji.\\n6. Tuangkan kuah kaldu beserta bakso sapi melimpah. Sajikan.";
            ingStr = getIngredientsJson(new String[]{
                "Pentol Bakso", "Tulang Sapi", "Mie Kuning", "Soun", "Bawang Putih",
                "Pala Bubuk", "Lada Bubuk", "Seledri", "Daun Bawang", "Garam"
            }, new String[]{
                "10 butir", "300g", "50g", "50g", "5 siung",
                "1/2 sdt", "1 sdt", "2 batang", "1 batang", "1.5 sdt"
            });
        } else if (id.equals("10028")) {
            name = "Ketoprak Jakarta";
            category = "Mie & Sayur";
            thumb = "https://www.themealdb.com/images/media/meals/6g3rso1763486069.jpg";
            instructions = "1. Goreng tahu putih hingga setengah kering, potong-potong.\\n2. Ulek cabai rawit merah, bawang putih, garam, dan gula merah di piring saji.\\n3. Tambahkan kacang tanah goreng giling, beri air hangat dan perasan jeruk limau, ulek rata hingga menjadi saus kacang kental.\\n4. Tata potongan lontong, tahu goreng, bihun, dan tauge di atas saus kacang.\\n5. Siram ketoprak dengan kecap manis melimpah.\\n6. Taburi bawang merah goreng dan kerupuk kanji.";
            ingStr = getIngredientsJson(new String[]{
                "Lontong", "Tahu Putih", "Bihun", "Tauge", "Kacang Tanah",
                "Bawang Putih", "Gula Merah", "Kecap Manis", "Jeruk Limau", "Kerupuk"
            }, new String[]{
                "1 buah", "2 buah", "50g", "50g", "100g",
                "1 siung", "15g", "3 sdm", "1/2 buah", "secukupnya"
            });
        } else if (id.equals("10029")) {
            name = "Klepon Pandan";
            category = "Pencuci Mulut";
            thumb = "https://www.themealdb.com/images/media/meals/6ut2og1619790195.jpg";
            instructions = "1. Campur tepung ketan dengan garam and air sari pandan suji hangat sedikit demi sedikit hingga kalis.\\n2. Ambil sedikit adonan ketan, pipihkan, isi tengahnya dengan serutan gula merah.\\n3. Bulatkan kembali adonan ketan hingga gula merah tertutup rapat.\\n4. Rebus bola-bola ketan di air mendidih hingga mengapung. Angkat.\\n5. Gulingkan bola klepon ke dalam kelapa parut kukus gurih.\\n6. Sajikan hangat agar isi gula merah meleleh.";
            ingStr = getIngredientsJson(new String[]{
                "Tepung Ketan", "Air Pandan", "Gula Merah", "Kelapa Parut", "Garam",
                "Air", "Tepung Beras", "Daun Suji", "Gula Pasir", "Susu"
            }, new String[]{
                "200g", "150ml", "100g", "100g", "1/2 sdt",
                "50ml", "1 sdm", "secukupnya", "secukupnya", "secukupnya"
            });
        } else if (id.equals("10030")) {
            name = "Kolak Pisang";
            category = "Pencuci Mulut";
            thumb = "https://www.themealdb.com/images/media/meals/5pmn0g1779813285.jpg";
            instructions = "1. Kupas pisang kepok, potong serong memanjang.\\n2. Rebus air bersama gula merah, gula pasir, daun pandan, dan sedikit garam hingga larut. Saring.\\n3. Didihkan kembali air gula, masukkan pisang kepok dan kolang-kaling.\\n4. Masak hingga pisang setengah matang.\\n5. Tuang santan kelapa sambil diaduk perlahan agar santan tidak pecah.\\n6. Masak dengan api kecil hingga pisang empuk manis matang.";
            ingStr = getIngredientsJson(new String[]{
                "Pisang Kepok", "Kolang-Kaling", "Santan Kelapa", "Gula Merah", "Gula Pasir",
                "Daun Pandan", "Garam", "Air", "Ubi", "Singkong"
            }, new String[]{
                "5 buah", "100g", "400ml", "150g", "2 sdm",
                "2 lembar", "1/4 sdt", "200ml", "secukupnya", "secukupnya"
            });
        } else if (id.equals("10031")) {
            name = "Nasi Uduk Jakarta";
            category = "Daging";
            thumb = "https://www.themealdb.com/images/media/meals/er4d081765186828.jpg";
            instructions = "1. Cuci bersih beras, tiriskan.\\n2. Rebus santan bersama serai memar, daun salam, daun pandan, dan garam hingga harum dan mendidih.\\n3. Masukkan beras ke dalam santan rebus, masak di atas api sedang sambil diaduk sesekali hingga santan terserap habis (menjadi nasi aron).\\n4. Kukus nasi aron di dalam kukusan panas selama 45 menit hingga matang empuk pulen.\\n5. Sajikan nasi uduk gurih ini dengan taburan bawang goreng, telur dadar iris, ayam goreng, semur tahu, tempe orek, dan sambal kacang.";
            ingStr = getIngredientsJson(new String[]{
                "Beras", "Santan Kelapa", "Serai", "Daun Salam", "Daun Pandan",
                "Garam", "Bawang Goreng", "Telur", "Ayam Goreng", "Sambal"
            }, new String[]{
                "500g", "600ml", "2 batang", "3 lembar", "2 lembar",
                "1.5 sdt", "secukupnya", "2 butir", "secukupnya", "secukupnya"
            });
        } else if (id.equals("10032")) {
            name = "Tahu Gejrot Cirebon";
            category = "Mie & Sayur";
            thumb = "https://www.themealdb.com/images/media/meals/j9nray1765657692.jpg";
            instructions = "1. Potong-potong tahu pong goreng menjadi bagian kecil.\\n2. Ulek kasar bawang merah, bawang putih, cabai rawit hijau, dan sedikit garam di cobek.\\n3. Rebus air, gula merah, asam jawa, dan sedikit kecap manis hingga gula larut mendidih mendirikan kuah tahu gejrot. Saring dan dinginkan.\\n4. Campurkan bumbu ulek kasar dengan kuah asam manis pedas gula merah di cobek.\\n5. Masukkan potongan tahu pong ke dalam cobek, aduk dan tekan perlahan agar kuah meresap ke dalam tahu.\\n6. Sajikan langsung di cobek tanah liat.";
            ingStr = getIngredientsJson(new String[]{
                "Tahu Pong", "Bawang Merah", "Bawang Putih", "Cabai Rawit", "Gula Merah",
                "Asam Jawa", "Kecap Manis", "Air", "Garam", "Minyak"
            }, new String[]{
                "10 buah", "4 butir", "2 siung", "8 buah", "50g",
                "20g", "1 sdm", "150ml", "1/2 sdt", "secukupnya"
            });
        } else if (id.equals("10033")) {
            name = "Bubur Sumsum";
            category = "Pencuci Mulut";
            thumb = "https://www.themealdb.com/images/media/meals/dm8kee1779553541.jpg";
            instructions = "1. Larutkan sebagian santan dengan tepung beras dan garam, aduk rata.\\n2. Rebus sisa santan bersama daun pandan hingga hangat mendidih.\\n3. Tuangkan larutan tepung beras ke dalam santan rebus.\\n4. Masak di atas api kecil sambil diaduk cepat tanpa henti hingga mengental meletup-letup. Angkat.\\n5. Rebus gula merah, air, dan daun pandan hingga mendidih kental.\\n6. Sajikan bubur dengan siraman kuah gula merah.";
            ingStr = getIngredientsJson(new String[]{
                "Tepung Beras", "Santan Kelapa", "Garam", "Daun Pandan", "Gula Merah",
                "Air", "Gula Pasir", "Susu", "Nangka", "Es"
            }, new String[]{
                "100g", "750ml", "1/2 sdt", "3 lembar", "150g",
                "150ml", "secukupnya", "secukupnya", "secukupnya", "secukupnya"
            });
        } else if (id.equals("10034")) {
            name = "Lumpia Semarang";
            category = "Pencuci Mulut";
            thumb = "https://www.themealdb.com/images/media/meals/9r2xrg1763771238.jpg";
            instructions = "1. Cuci bersih rebung iris, rebus berulang kali hingga baunya hilang, tiriskan.\\n2. Tumis bawang putih cincang hingga harum, masukkan ebi halus dan daging ayam cincang serta telur orak-arik.\\n3. Masukkan rebung rebus, bumbui dengan kecap manis, saus tiram, garam, lada, dan gula pasir hingga meresap kering.\\n4. Siapkan kulit lumpia, beri isian tumisan rebung ayam, gulung rapat rekatkan ujungnya dengan larutan tepung.\\n5. Goreng lumpia dalam minyak panas hingga berwarna cokelat keemasan garing renyah.\\n6. Sajikan hangat dengan saus cocolan kental manis pedas, daun bawang muda, dan acar timun.";
            ingStr = getIngredientsJson(new String[]{
                "Kulit Lumpia", "Rebung Iris", "Daging Ayam", "Telur Ayam", "Ebi Kering",
                "Bawang Putih", "Kecap Manis", "Saus Tiram", "Garam", "Minyak"
            }, new String[]{
                "10 lembar", "250g", "100g", "2 butir", "1 sdm",
                "4 siung", "3 sdm", "1 sdm", "1 sdt", "secukupnya"
            });
        } else if (id.equals("10035")) {
            name = "Tahu Tek Surabaya";
            category = "Daging";
            thumb = "https://www.themealdb.com/images/media/meals/t2b8bn1779737789.jpg";
            instructions = "1. Goreng tahu putih setengah matang, potong-potong.\\n2. Dadar telur ayam kocok bersama potongan tahu putih, sisihkan.\\n3. Ulek bawang putih goreng, cabai rawit, petis udang Sidoarjo kualitas bagus, gula merah, garam, dan kacang tanah goreng giling hingga halus merata.\\n4. Tambahkan air hangat sedikit demi sedikit sambil diulek hingga menjadi saus petis kental gurih harum.\\n5. Tata lontong iris, tahu telur dadar hangat, tauge rebus pendek, dan potongan kentang rebus.\\n6. Siram saus petis kental di atasnya. Taburi seledri iris, bawang goreng, dan kerupuk udang kecil.";
            ingStr = getIngredientsJson(new String[]{
                "Tahu Putih", "Telur Ayam", "Petis Udang", "Kacang Tanah", "Bawang Putih",
                "Cabai Rawit", "Lontong", "Tauge", "Kentang Rebus", "Kerupuk"
            }, new String[]{
                "2 buah", "2 butir", "2 sdm", "50g", "2 siung",
                "5 buah", "1 buah", "50g", "1 buah", "secukupnya"
            });
        } else if (id.equals("10036")) {
            name = "Bubur Ayam Jakarta";
            category = "Ayam";
            thumb = "https://www.themealdb.com/images/media/meals/1529446352.jpg";
            instructions = "1. Masak beras bersama air kaldu ayam, daun salam, dan garam di atas api sedang sambil diaduk berkala hingga beras pecah lembut menjadi bubur kental halus.\\n2. Buat kuah kuning: tumis bawang merah, bawang putih, kunyit, kemiri, ketumbar, jahe hingga harum, tuang air kaldu ayam, beri garam dan lada, masak hingga mendidih bumbu meresap.\\n3. Goreng dada ayam hingga berkulit cokelat keemasan, suwir dagingnya.\\n4. Sajikan bubur hangat di mangkuk, tuang sedikit kuah kuning.\\n5. Beri taburan suwiran ayam, cakwe iris, seledri, bawang goreng, kacang kedelai goreng, kerupuk, emping, dan sambal.";
            ingStr = getIngredientsJson(new String[]{
                "Beras", "Kaldu Ayam", "Dada Ayam", "Daun Salam", "Cakwe",
                "Kuning Kunyit", "Bawang Putih", "Bawang Merah", "Kacang Kedelai", "Kerupuk"
            }, new String[]{
                "150g", "1.5 liter", "200g", "2 lembar", "1 buah",
                "2cm", "3 siung", "4 butir", "50g", "secukupnya"
            });
        } else if (id.equals("10037")) {
            name = "Lontong Sayur";
            category = "Mie & Sayur";
            thumb = "https://www.themealdb.com/images/media/meals/4k8nzy1763583384.jpg";
            instructions = "1. Haluskan bawang merah, bawang putih, cabai merah, kunyit, jahe, dan kemiri. Tumis bumbu halus bersama daun salam, daun jeruk, serai, dan lengkuas memar hingga matang berminyak wangi.\\n2. Masukkan potongan labu siam atau pepaya muda iris korek api, aduk rata.\\n3. Tuangkan santan encer, masak hingga mendidih dan labu siam setengah empuk.\\n4. Masukkan santan kental, garam, dan sedikit gula. Aduk perlahan di api sedang agar santan tidak pecah hingga matang.\\n5. Tata lontong iris di mangkuk saji, siram dengan sayur labu siam bersantan kuning gurih pedas.\\n6. Taburi telur rebus, bawang goreng, dan kerupuk merah.";
            ingStr = getIngredientsJson(new String[]{
                "Lontong", "Labu Siam", "Santan Encer", "Santan Kental", "Bawang Merah",
                "Bawang Putih", "Cabai Merah", "Serai", "Telur Rebus", "Kerupuk"
            }, new String[]{
                "2 buah", "200g", "500ml", "200ml", "6 butir",
                "4 siung", "5 buah", "1 batang", "2 butir", "secukupnya"
            });
        } else if (id.equals("10038")) {
            name = "Bebek Goreng Madura";
            category = "Ayam";
            thumb = "https://www.themealdb.com/images/media/meals/hglsbl1614346998.jpg";
            instructions = "1. Bersihkan bebek, lumuri cuka atau jeruk nipis untuk hilangkan bau amis, bilas air.\\n2. Haluskan bumbu melimpah: bawang merah, bawang putih, kemiri, ketumbar, merica, kunyit, jahe, lengkuas kencur, serai, cabai rawit hitam.\\n3. Ungkep bebek bersama bumbu halus and sedikit air di atas api kecil dalam panci tertutup selama 1.5 jam hingga daging bebek sangat empuk dan bumbu meresap berminyak.\\n4. Angkat bebek, goreng dalam minyak sangat panas hingga kering kecokelatan krispi luar.\\n5. Masak sisa bumbu ungkepan bebek di wajan dengan sisa minyak goreng di api kecil hingga berwarna hitam gelap pekat harum gurih pedas.\\n6. Sajikan bebek goreng hangat dengan lumuran bumbu hitam Madura, lalapan segar, dan nasi hangat.";
            ingStr = getIngredientsJson(new String[]{
                "Daging Bebek", "Bawang Merah", "Bawang Putih", "Kemiri", "Kunyit",
                "Jahe", "Lengkuas", "Ketumbar", "Cabai Rawit", "Minyak Goreng"
            }, new String[]{
                "1/2 ekor", "15 butir", "8 siung", "6 butir", "4cm",
                "3cm", "5cm", "1.5 sdm", "15 buah", "secukupnya"
            });
        } else if (id.equals("10039")) {
            name = "Pecel Lele";
            category = "Seafood";
            thumb = "https://www.themealdb.com/images/media/meals/9q1ci41779735714.jpg";
            instructions = "1. Bersihkan ikan lele, kerat-kerat badannya, lumuri air jeruk nipis.\\n2. Haluskan bawang putih, ketumbar, kunyit, dan garam. Balurkan ke badan ikan lele, diamkan 15 menit.\\n3. Goreng lele dalam minyak panas yang banyak (deep fry) hingga garing renyah kering merata. Angkat tiriskan.\\n4. Buat sambal pecel: goreng bawang merah, bawang putih, cabai merah, cabai rawit merah, tomat, terasi, dan kemiri. Ulek halus bersama garam, gula merah, dan sedikit perasan jeruk limau.\\n5. Sajikan lele goreng garing hangat di cobek bersama siraman sambal pecel pedas gurih manis dan lalapan segar daun kemangi, kubis, timun.";
            ingStr = getIngredientsJson(new String[]{
                "Ikan Lele", "Bawang Putih", "Ketumbar", "Cabai Merah", "Cabai Rawit",
                "Tomat Merah", "Terasi Bakar", "Gula Merah", "Jeruk Limau", "Lalapan"
            }, new String[]{
                "3 ekor", "4 siung", "1 sdm", "5 buah", "8 buah",
                "1 buah", "1 sdt", "1 sdm", "1/2 buah", "secukupnya"
            });
        } else if (id.equals("10040")) {
            name = "Serabi Solo";
            category = "Pencuci Mulut";
            thumb = "https://www.themealdb.com/images/media/meals/vmz7gl1614350221.jpg";
            instructions = "1. Rebus santan bersama daun pandan dan sedikit garam hingga mendidih wangi, dinginkan.\\n2. Campur tepung beras, gula pasir, ragi instan, telur, dan separuh santan rebus. Aduk hingga rata tidak bergerindil.\\n3. Tuang sisa santan sedikit demi sedikit sambil dikocok perlahan selama 15 menit. Diamkan adonan selama 1 jam hingga mengembang berongga.\\n4. Panaskan cetakan serabi tanah liat atau wajan besi kecil, oles sedikit minyak.\\n5. Tuang satu sendok sayur adonan serabi, tekan bagian tengahnya dengan sendok untuk membuat pinggiran tipis krispi.\\n6. Tutup wajan, panggang hingga serabi setengah matang.\\n7. Beri topping irisan pisang, keju parut, atau cokelat meises, tutup kembali hingga matang lembut berserat. Gulung dengan daun pisang hangat, sajikan.";
            ingStr = getIngredientsJson(new String[]{
                "Tepung Beras", "Santan Kelapa", "Gula Pasir", "Ragi Instan", "Telur Ayam",
                "Garam", "Daun Pandan", "Cokelat Meises", "Keju Cheddar", "Daun Pisang"
            }, new String[]{
                "250g", "600ml", "100g", "1 sdt", "1 butir",
                "1/2 sdt", "2 lembar", "secukupnya", "secukupnya", "secukupnya"
            });
        }

        return "{\n" +
                "  \"meals\": [\n" +
                "    {\n" +
                "      \"idMeal\": \"" + id + "\",\n" +
                "      \"strMeal\": \"" + name + "\",\n" +
                "      \"strCategory\": \"" + category + "\",\n" +
                "      \"strInstructions\": \"" + instructions + "\",\n" +
                "      \"strMealThumb\": \"" + thumb + "\",\n" +
                ingStr +
                "      \"strArea\": \"Indonesia\"\n" +
                "    }\n" +
                "  ]\n" +
                "}";
    }

    private static String getIngredientsJson(String[] ing, String[] meas) {
        StringBuilder sb = new StringBuilder();
        for (int i = 0; i < 20; i++) {
            String ingVal = (i < ing.length) ? ing[i] : "";
            String measVal = (i < meas.length) ? meas[i] : "";
            sb.append("      \"strIngredient").append(i + 1).append("\": \"").append(ingVal).append("\",\n");
            sb.append("      \"strMeasure").append(i + 1).append("\": \"").append(measVal).append("\",\n");
        }
        return sb.toString();
    }
}
