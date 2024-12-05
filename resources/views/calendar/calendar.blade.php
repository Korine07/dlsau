@extends('calendar.layout')

@section('content')
<div class="custom-container text-white py-5">
    <div class="row justify-content-center">
        <!-- Calendar and Booking Form Section -->
        <div class="row mt-5">
            <!-- Calendar Section -->
            <div class="col-lg-8">
                <div class="calendar-container">
                    <div class="calendar-header">
                        <h2>January 2019</h2>
                        <div class="calendar-navigation">
                            <button class="btn-prev">«</button>
                            <button class="btn-today">Today</button>
                            <button class="btn-next">»</button>
                        </div>
                    </div>
                    <!-- Calendar Table -->
                    <table class="calendar">
                        <thead>
                            <tr>
                                <th>Sun</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="inactive">30</td>
                                <td class="inactive">31</td>
                                <td class="event">1<br><span class="event">All Day Event</span></td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td class="event">7<br><span>Long Event</span></td>
                                <td>8</td>
                                <td class="event">9<br><span>Repeating Event</span></td>
                                <td>10</td>
                                <td>11</td>
                                <td>12</td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td class="event">14<br><span>Birthday Party</span></td>
                                <td>15</td>
                                <td class="event">16<br><span>Repeating Event</span></td>
                                <td>17</td>
                                <td>18</td>
                                <td>19</td>
                            </tr>
                            <tr>
                                <td>20</td>
                                <td>21</td>
                                <td>22</td>
                                <td>23</td>
                                <td>24</td>
                                <td>25</td>
                                <td>26</td>
                            </tr>
                            <tr>
                                <td>27</td>
                                <td class="event">28<br><span>Click for Google</span></td>
                                <td>29</td>
                                <td>30</td>
                                <td>31</td>
                                <td class="inactive">1</td>
                                <td class="inactive">2</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Booking Form Section -->
            <div class="col-lg-4">
                <div class="form-container">
                    <h4>Holiday Form</h4>
                    <form>
                    <div class="form-group">
                            <label for="date">Holiday Date</label>
                            <input type="date" id="date">
                        </div>
                        <div class="form-group">
                            <label for="email">Holiday Reason</label>
                            <input type="email" id="email" placeholder="">
                        </div>
                        <div class="form-group">
                            <button type="button">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .calendar-container {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .calendar-header h2 {
        font-size: 18px;
        color: #333;
        margin: 0;
    }

    .calendar-navigation button {
        padding: 5px 10px;
        margin-left: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #007bff;
        color: #fff;
        cursor: pointer;
    }

    .calendar-navigation button:hover {
        background: #0056b3;
    }

    .calendar {
        width: 100%;
        border-collapse: collapse;
    }

    .calendar th,
    .calendar td {
        width: 14%;
        height: 100px;
        text-align: left;
        vertical-align: top;
        border: 1px solid #ddd;
        padding: 5px;
        font-size: 14px;
    }

    .calendar td.inactive {
        background-color: #f9f9f9;
        color: #aaa;
    }

    .calendar td.event {
        background-color: #e9f7ff;
        border-color: #bce8ff;
    }

    .calendar td span {
        display: block;
        margin-top: 5px;
        font-size: 12px;
        background: #007bff;
        color: #fff;
        padding: 2px 5px;
        border-radius: 3px;
        cursor: pointer;
    }

    .calendar td span:hover {
        background: #0056b3;
    }

    .form-container {
        background: #fff;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-container h4 {
        margin-bottom: 15px;
        font-size: 18px;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
        color: #555;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 8px;
        font-size: 14px;
        color: #333;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form-group textarea {
        resize: none;
        height: 80px;
    }

    .form-group button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 4px;
        cursor: pointer;
    }

    .form-group button:hover {
        background-color: #0056b3;
    }
</style>
@endsection
